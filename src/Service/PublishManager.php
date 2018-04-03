<?php
/**
 * author: abuchatskiy
 */

namespace App\Service;


use App\Entity\Photo;
use App\Repository\PhotoRepository;
use League\Flysystem\FilesystemInterface;
use RuntimeException;

/**
 * Class PublishManager
 * @package App\Service
 */
class PublishManager
{
    protected const TYPE_FILE = 'file';
    protected const TYPE_IMAGE_JPEG = 'image/jpeg';
    protected const IMAGE_FORMAT = 'jpg';

    /**
     * @var PhotoRepository
     */
    protected $photoRepo;

    /**
     * @var ImageManipulator
     */
    protected $imageManipulator;

    /**
     * @var FilesystemInterface
     */
    protected $dstFileSystem;

    /**
     * PublishManager constructor.
     * @param PhotoRepository $photoRepo
     * @param ImageManipulator $imageManipulator
     */
    public function __construct(PhotoRepository $photoRepo, ImageManipulator $imageManipulator)
    {
        $this->photoRepo = $photoRepo;
        $this->imageManipulator = $imageManipulator;
        $this->dstFileSystem = $imageManipulator->getDestination();
    }

    /**
     * @param Photo $photo
     * @param bool $state
     * @throws \League\Glide\Filesystem\FilesystemException
     * @throws \League\Glide\Filesystem\FileNotFoundException
     * @throws \League\Flysystem\FileExistsException
     * @throws \RuntimeException
     * @throws \Doctrine\ORM\ORMException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function changeState(Photo $photo, bool $state): void
    {
        if ($state) {
            $this->publishPhoto($photo);
        } else {
            $this->unpublishPhoto($photo);
        }
        $this->photoRepo->setPublished($photo, $state);
    }

    /**
     * @throws \League\Glide\Filesystem\FilesystemException
     * @throws \League\Glide\Filesystem\FileNotFoundException
     * @throws \RuntimeException
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function republishAll(): void
    {
        foreach ($this->photoRepo->findAllPublished() as $photo) {
            $this->publishPhoto($photo);
        }
    }

    /**
     * @throws \League\Glide\Filesystem\FilesystemException
     * @throws \League\Glide\Filesystem\FileNotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \League\Flysystem\FileExistsException
     * @throws \RuntimeException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function sunchronyzeWithDb(): void
    {
        foreach ($this->dstFileSystem->listContents('', true) as $item) {
            if (self::TYPE_FILE === $item['type']) {
                $fullPath = $item['path'];
                if (
                    self::TYPE_IMAGE_JPEG === $this->dstFileSystem->getMimetype($fullPath)
                    && null === $this->photoRepo->findOneByFullPath($fullPath)
                ) {
                    $this->dstFileSystem->delete($fullPath);
                }
            }
        }

        foreach ($this->photoRepo->findAll() as $photo) {
            $fullPath = $photo->getFullPath();
            if ($photo->isPublished()) {
                if (!$this->dstFileSystem->has($fullPath)) {
                    $this->publishPhoto($photo);
                }
            } else {
                if ($this->dstFileSystem->has($fullPath)) {
                    $this->unpublishPhoto($photo);
                }
            }
        }
    }

    /**
     * @param Photo $photo
     * @throws \League\Glide\Filesystem\FilesystemException
     * @throws \League\Glide\Filesystem\FileNotFoundException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \League\Flysystem\FileExistsException
     */
    protected function publishPhoto(Photo $photo): void
    {
        $fullPath = $photo->getFullPath();
        $this->imageManipulator->publishImage($fullPath, []);
    }

    /**
     * @param Photo $photo
     * @throws \RuntimeException
     * @throws \League\Flysystem\FileNotFoundException
     */
    protected function unpublishPhoto(Photo $photo): void
    {
        $fullPath = $photo->getFullPath();
        if ($this->dstFileSystem->has($fullPath) && false === $this->dstFileSystem->delete($fullPath)) {
            throw new RuntimeException("Unable to delete destination file: $fullPath");
        }
    }
}