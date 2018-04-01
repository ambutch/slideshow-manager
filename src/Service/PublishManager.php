<?php
/**
 * author: abuchatskiy
 */

namespace App\Service;


use App\Entity\Photo;
use App\Repository\PhotoRepository;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
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
     * @var FilesystemInterface
     */
    protected $srcFileSystem;

    /**
     * @var FilesystemInterface
     */
    protected $dstFileSystem;

    /**
     * @var ImageManager
     */
    protected $imageManager;

    /**
     * @var int
     */
    protected $maxWidth;

    /**
     * @var int
     */
    protected $maxHeight;

    /**
     * PublishManager constructor.
     * @param PhotoRepository $photoRepo
     * @param FilesystemInterface $srcFileSystem
     * @param FilesystemInterface $dstFileSystem
     * @param int $maxWidth
     * @param int $maxHeight
     */
    public function __construct(
        PhotoRepository $photoRepo,
        FilesystemInterface $srcFileSystem,
        FilesystemInterface $dstFileSystem,
        int $maxWidth,
        int $maxHeight
    )
    {
        $this->photoRepo = $photoRepo;
        $this->srcFileSystem = $srcFileSystem;
        $this->dstFileSystem = $dstFileSystem;
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;

        $this->imageManager = new ImageManager();
    }


    /**
     * @param Photo $photo
     * @param bool $state
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
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \RuntimeException
     */
    protected function publishPhoto(Photo $photo): void
    {
        $fullPath = $photo->getFullPath();

        if (!$this->srcFileSystem->has($fullPath)) {
            throw new RuntimeException('Source file does not exist');
        }
        if (false === ($imageData = $this->srcFileSystem->read($fullPath))) {
            throw new RuntimeException('Source file cannot be read');
        }

        $image = $this->imageManager->make($imageData);
        $this->resizeImage($image);

        if ($this->dstFileSystem->has($fullPath)) {
            $this->dstFileSystem->delete($fullPath);
        }

        $this->dstFileSystem->write($fullPath, $image->encode(self::IMAGE_FORMAT));
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

    /**
     * @param Image $image
     */
    protected function resizeImage(Image $image): void
    {
        $widthRatio = $image->getWidth() / $this->maxWidth;
        $heightRatio = $image->getHeight() / $this->maxHeight;

        if ($widthRatio < 1 || $heightRatio < 1) {
            return;
        }

        if ($widthRatio < $heightRatio) {
            /** @noinspection PhpParamsInspection */
            $image->widen($this->maxWidth);
        } else {
            /** @noinspection PhpParamsInspection */
            $image->heighten($this->maxHeight);
        }
    }
}