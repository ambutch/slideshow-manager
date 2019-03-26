<?php
/**
 * author: abuchatskiy
 */

namespace App\Service\ApiHandler;


use Api\CommandApiInterface;
use App\Service\ApiManager\Command as CommandManager;

class Command implements CommandApiInterface
{
    /**
     * @var CommandManager
     */
    protected $manager;

    /**
     * Command constructor.
     * @param CommandManager $manager
     */
    public function __construct(CommandManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Updates the database
     *
     * @param  integer $responseCode The HTTP response code to return
     * @param  array $responseHeaders Additional HTTP headers to return with the response ()
     * @return void
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \League\Glide\Filesystem\FileNotFoundException
     * @throws \League\Glide\Filesystem\FilesystemException
     * @throws \LogicException
     * @throws \RuntimeException
     */
    public function update(&$responseCode, array &$responseHeaders)
    {
        $this->manager->update();
    }
}