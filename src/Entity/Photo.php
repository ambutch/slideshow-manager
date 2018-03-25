<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @var Uuid
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     */
    protected $id;

    /**
     * @var Directory
     * @ORM\ManyToOne(targetEntity="Directory", inversedBy="photos", cascade="all")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $parent;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $baseName;

    /**
     * @var string
     * @ORM\Column(type="string", length=1024)
     */
    protected $fullPath;

    /**
     * @var bool
     * @ORM\Column(type="boolean", options={"default":false})
     */
    protected $published = false;

    /**
     * Photo constructor.
     * @param Directory $parent
     * @param string $baseName
     * @param string $fullPath
     */
    public function __construct(Directory $parent, string $baseName, string $fullPath)
    {
        $this->id = Uuid::uuid5($parent->getId(), $baseName);
        $this->parent = $parent;
        $this->baseName = $baseName;
        $this->fullPath = $fullPath;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return Directory
     */
    public function getParent(): Directory
    {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function getBaseName(): string
    {
        return $this->baseName;
    }

    /**
     * @return string
     */
    public function getFullPath(): string
    {
        return $this->fullPath;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @param bool $published
     * @return Photo
     */
    public function setPublished(bool $published): Photo
    {
        $this->published = $published;
        return $this;
    }

}
