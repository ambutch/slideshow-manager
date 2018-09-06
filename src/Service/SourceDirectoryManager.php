<?php
/**
 * author: abuchatskiy
 */

namespace App\Service;


use App\Entity\Directory;
use App\Entity\Photo;
use App\Helper\DirectoryAuditor;
use App\Repository\DirectoryRepository;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemInterface;
use LogicException;

/**
 * Class SourceDirectoryManager
 * @package App\Services
 */
class SourceDirectoryManager
{
    protected const TYPE_DIR = 'dir';
    protected const TYPE_FILE = 'file';
    protected const TYPE_IMAGE_JPEG = 'image/jpeg';

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var DirectoryRepository
     */
    protected $directoryRepository;

    /**
     * @var PhotoRepository
     */
    protected $photoRepository;

    /**
     * @var FilesystemInterface
     */
    protected $fileSystem;

    /**
     * SourceDirectoryManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param FilesystemInterface $fileSystem
     */
    public function __construct(EntityManagerInterface $entityManager, FilesystemInterface $fileSystem)
    {
        $this->fileSystem = $fileSystem;
        $this->entityManager = $entityManager;
        $this->directoryRepository = $this->entityManager->getRepository(Directory::class);
        $this->photoRepository = $this->entityManager->getRepository(Photo::class);
    }

    /**
     * @param Directory|null $directory
     * @throws \LogicException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function scan(Directory $directory = null): void
    {
        if (null === $directory) {
            $directory = $this->getRootDirectory();
        }
        $this->scanDirectory($directory, true);
        $this->entityManager->flush();
    }

    /**
     * @return Directory
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\ORMException
     */
    protected function getRootDirectory(): Directory
    {
        if (null === ($rootDir = $this->directoryRepository->findOneRoot())) {
            $rootDir = new Directory();
            $this->entityManager->persist($rootDir);
            $this->entityManager->flush();
            $rootDir = $this->directoryRepository->findOneRoot();
        }
        return $rootDir;
    }

    /**
     * @param Directory $directory
     * @param bool|null $recurse
     * @param string|null $path
     * @throws \LogicException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     * @throws \League\Flysystem\FileNotFoundException
     */
    protected function scanDirectory(Directory $directory, bool $recurse = null, string $path = null): void
    {
        if (null === $path) {
            $path = $this->directoryRepository->getNamePath($directory);
        } else {
            $path .= $directory->getName() . DIRECTORY_SEPARATOR;
        }

        $auditResult = $this->auditDirectory($directory, $path);
        $directory = $this->synchronizeDirectoryData($directory, $auditResult);

        if ($recurse ?: false) {
            $childDirectories = $this->directoryRepository->getChildren($directory, true);
            if (\is_array($childDirectories)) {
                foreach ($childDirectories as $childDirectory) {
                    $this->scanDirectory($childDirectory, true, $path);
                }
            }
        }
    }

    /**
     * @param Directory $directory
     * @param string $path
     * @return DirectoryAuditor
     * @throws \League\Flysystem\FileNotFoundException
     */
    protected function auditDirectory(Directory $directory, string $path): DirectoryAuditor
    {
        $contents = $this->fileSystem->listContents($path);
        $audit = new DirectoryAuditor($directory);
        foreach ($contents as $object) {
            if (self::TYPE_DIR === $object['type']) {
                $audit->checkChildName($object['basename']);
            } elseif (self::TYPE_FILE === $object['type']) {
                $filePath = $object['path'];
                if (self::TYPE_IMAGE_JPEG === $this->fileSystem->getMimetype($filePath)) {
                    $audit->checkPhotoName($object['basename'], $filePath);
                }
            }
        }
        return $audit;
    }

    /**
     * @param Directory $directory
     * @param DirectoryAuditor $audit
     * @return Directory
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \LogicException
     * @throws \Doctrine\ORM\ORMException
     */
    protected function synchronizeDirectoryData(Directory $directory, DirectoryAuditor $audit): Directory
    {
        foreach ($audit->getDeletedChildren() as $deletedChild) {
            foreach ($deletedChild->getPhotosRecurse() as $deletedPhoto) {
                $this->entityManager->remove($deletedPhoto);
            }
            $directory->removeChild($deletedChild);
            $this->entityManager->remove($deletedChild);
        }
        foreach ($audit->getDeletedPhotos() as $deletedPhoto) {
            $directory->removePhoto($deletedPhoto);
            $this->entityManager->remove($deletedPhoto);
        }

        foreach ($audit->getNewChildNames() as $name) {
            $child = new Directory($name, $directory);
            $this->entityManager->persist($child);
        }
        foreach ($audit->getNewPhotoNames() as $name) {
            $path = $audit->getPhotoPathByName($name);
            $photo = new Photo($directory, $name, $path);
            $this->entityManager->persist($photo);
        }

        $directoryId = $directory->getId();
        $this->entityManager->flush();

        if (null === ($directory = $this->directoryRepository->findOneById($directoryId))) {
            throw new LogicException("Directory with id:`$directoryId` not found after flush");
        }
        return $directory;
    }
}