<?php
/**
 * author: abuchatskiy
 */

namespace App\Service\ApiManager;


use App\Service\PublishManager;
use App\Service\SourceDirectoryManager;

/**
 * Class Command
 * @package App\Service\ApiManager
 */
class Command
{
    /**
     * @var SourceDirectoryManager
     */
    protected $directoryManager;

    /**
     * @var PublishManager
     */
    protected $publishManager;

    /**
     * Command constructor.
     * @param SourceDirectoryManager $directoryManager
     * @param PublishManager $publishManager
     */
    public function __construct(SourceDirectoryManager $directoryManager, PublishManager $publishManager)
    {
        $this->directoryManager = $directoryManager;
        $this->publishManager = $publishManager;
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \League\Glide\Filesystem\FileNotFoundException
     * @throws \League\Glide\Filesystem\FilesystemException
     */
    public function update(): void
    {
        $this->directoryManager->scan();
        $this->publishManager->sunchronyzeWithDb();
    }
}