<?php
/**
 * author: abuchatskiy
 */

namespace App\Service;


use League\Flysystem\FilesystemInterface;
use League\Glide\Filesystem\FilesystemException;
use League\Glide\Server;

/**
 * Class ImageManipulator
 * @package App\Service
 */
class ImageManipulator extends Server
{

    /**
     * @var FilesystemInterface
     */
    protected $destination;

    /**
     * @return FilesystemInterface
     */
    public function getDestination(): FilesystemInterface
    {
        return $this->destination;
    }

    /**
     * @param FilesystemInterface $destination
     * @return ImageManipulator
     */
    public function setDestination(FilesystemInterface $destination): ImageManipulator
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * @param string $path
     * @param array $params
     * @throws \League\Glide\Filesystem\FileNotFoundException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \League\Glide\Filesystem\FilesystemException
     * @throws \InvalidArgumentException
     */
    public function publishImage(string $path, array $params): void
    {
        $cachePath = $this->makeImage($path, $params);

        $source = $this->cache->read($cachePath);

        if ($source === false) {
            throw new FilesystemException("Could not read the image `$cachePath`.");
        }

        if (false === $this->destination->put($path, $source)) {
            throw new FilesystemException("Could not write the image `$path`.");
        }

        $this->deleteCache($path);
    }
}