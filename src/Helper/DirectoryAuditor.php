<?php
/**
 * author: abuchatskiy
 */

namespace App\Helper;


use App\Entity\Directory;
use App\Entity\Photo;

/**
 * Class DirectoryAuditor
 * @package App\Helpers
 */
class DirectoryAuditor
{
    /**
     * @var Directory[]
     */
    protected $deletedChildren;

    /**
     * @var Photo[]
     */
    protected $deletedPhotos;

    /**
     * @var string[]
     */
    protected $newPhotoPaths = [];

    /**
     * @var string[]
     */
    protected $newChildNames = [];

    /**
     * DirectoryAuditor constructor.
     * @param Directory $directory
     */
    public function __construct(Directory $directory)
    {
        $this->deletedChildren = $directory->getChildrenNameAsIndex();
        $this->deletedPhotos = $directory->getPhotosNameAsIndex();
    }

    /**
     * @param string $name
     */
    public function checkChildName(string $name): void
    {
        if(\array_key_exists($name, $this->deletedChildren)) {
            unset($this->deletedChildren[$name]);
        } else {
            $this->newChildNames[] = $name;
        }
    }

    /**
     * @param string $name
     * @param string $path
     */
    public function checkPhotoName(string $name, string $path): void
    {
        if(\array_key_exists($name, $this->deletedPhotos)) {
            unset($this->deletedPhotos[$name]);
        } else {
            $this->newPhotoPaths[$name] = $path;
        }
    }

    /**
     * @return Directory[]
     */
    public function getDeletedChildren(): array
    {
        return $this->deletedChildren;
    }

    /**
     * @return Photo[]
     */
    public function getDeletedPhotos(): array
    {
        return $this->deletedPhotos;
    }

    /**
     * @return string[]
     */
    public function getNewPhotoNames(): array
    {
        return array_keys($this->newPhotoPaths);
    }

    /**
     * @param string $name
     * @return string
     */
    public function getPhotoPathByName(string $name): string
    {
        return $this->newPhotoPaths[$name];
    }

    /**
     * @return string[]
     */
    public function getNewChildNames(): array
    {
        return $this->newChildNames;
    }

}