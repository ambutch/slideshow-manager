<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as ORM_Extra;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DirectoryRepository")
 * @ORM_Extra\Tree(type="nested")
 */
class Directory
{
    public const ROOT_UUID_STRING = '910cf3a1-470b-4d23-b865-e5117d5c72ee';

    /**
     * @var Uuid
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM_Extra\TreeParent
     * @ORM\ManyToOne(targetEntity="Directory")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $parent;

    /**
     * @ORM_Extra\TreeLeft
     * @ORM\Column(type="integer")
     */
    protected $lft;

    /**
     * @ORM_Extra\TreeRight
     * @ORM\Column(type="integer")
     */
    protected $rgt;

    /**
     * @ORM_Extra\TreeRoot
     * @ORM\ManyToOne(targetEntity="Directory")
     * @ORM\JoinColumn(name="root_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $root;

    /**
     * @ORM_Extra\TreeLevel
     * @ORM\Column(type="integer")
     */
    protected $lvl;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="parent")
     */
    protected $photos;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Directory", mappedBy="parent")
     */
    protected $children;

    /**
     * Directory constructor.
     * @param string $name
     * @param Directory|null $parent
     */
    public function __construct(string $name = null, Directory $parent = null)
    {
        $this->photos = new ArrayCollection();
        $this->children = new ArrayCollection();

        if (null !== $parent) {
            $this->id = Uuid::uuid5($parent->getId(), $name);
            $this->parent = $parent;
        } else {
            $this->id = Uuid::fromString(self::ROOT_UUID_STRING);
            $name = '';
        }

        $this->name = $name;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Directory|null
     */
    public function getParent(): ?Directory
    {
        return $this->parent;
    }

    /**
     * @return Directory[]
     */
    public function getChildDirectories(): array
    {
        return $this->children->toArray();
    }

    /**
     * @return Directory[]
     */
    public function getChildrenIdAsIndex(): array
    {
        $result = [];
        foreach ($this->children as $child) {
            /** @var Directory $child */
            $result[$child->getId()->toString()] = $child;
        }
        return $result;
    }

    /**
     * @return Directory[]
     */
    public function getChildrenNameAsIndex(): array
    {
        $result = [];
        foreach ($this->children as $child) {
            /** @var Directory $child */
            $result[$child->getName()] = $child;
        }
        return $result;
    }

    /**
     * @return Photo[]
     */
    public function getPhotosIdAsIndex(): array
    {
        $result = [];
        foreach ($this->photos as $photo) {
            /** @var Photo $photo */
            $result[$photo->getId()->toString()] = $photo;
        }
        return $result;
    }

    /**
     * @return Photo[]
     */
    public function getPhotosNameAsIndex(): array
    {
        $result = [];
        foreach ($this->photos as $photo) {
            /** @var Photo $photo */
            $result[$photo->getBaseName()] = $photo;
        }
        return $result;
    }

    /**
     * @return Photo[]
     */
    public function getPhotos(): array
    {
        return $this->photos->toArray();
    }

    /**
     * @return Photo[]
     */
    public function getPhotosRecurse(): array
    {
        $photos = [];
        foreach ($this->children as $child) {
            /** @var Directory $child */
            /** @noinspection SlowArrayOperationsInLoopInspection */
            $photos = array_merge($photos, $child->getPhotosRecurse());
        }
        return array_merge($photos, $this->getPhotos());
    }

    /**
     * @param Directory $child
     * @return Directory
     */
    public function removeChild(Directory $child): self
    {
        $this->children->removeElement($child);
        return $this;
    }

    /**
     * @param Photo $photo
     * @return Directory
     */
    public function removePhoto(Photo $photo): self
    {
        $this->photos->removeElement($photo);
        return $this;
    }

}
