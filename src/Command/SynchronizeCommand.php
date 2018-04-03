<?php
/**
 * author: abuchatskiy
 */

namespace App\Command;


use App\Service\PublishManager;
use App\Service\SourceDirectoryManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SynchronizeCommand
 * @package App\Command
 */
class SynchronizeCommand extends Command
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
     * SynchronizeCommand constructor.
     * @param SourceDirectoryManager $directoryScanner
     * @param PublishManager $publishManager
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(SourceDirectoryManager $directoryScanner, PublishManager $publishManager)
    {
        parent::__construct();
        $this->directoryManager = $directoryScanner;
        $this->publishManager = $publishManager;
    }

    /**
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure(): void
    {
        $this
            ->setName('app:sync')
            ->setDescription('Scans the photo source directory. Synchronizes the destination directory.')
            ->setHelp('This command scans the photo source directory and updates the DB with actual data');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \League\Glide\Filesystem\FilesystemException
     * @throws \League\Glide\Filesystem\FileNotFoundException
     * @throws \RuntimeException
     * @throws \League\Flysystem\FileExistsException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     * @throws \LogicException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \League\Flysystem\FileNotFoundException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->directoryManager->scan();
        $this->publishManager->sunchronyzeWithDb();
        $output->writeln('Done!');
    }
}