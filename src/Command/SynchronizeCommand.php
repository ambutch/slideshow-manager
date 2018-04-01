<?php
/**
 * author: abuchatskiy
 */

namespace App\Command;


use App\Service\DirectoryScanner;
use App\Service\PublishManager;
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
     * @var DirectoryScanner
     */
    protected $directoryScanner;

    /**
     * @var PublishManager
     */
    protected $publishManager;

    /**
     * SynchronizeCommand constructor.
     * @param DirectoryScanner $directoryScanner
     * @param PublishManager $publishManager
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(DirectoryScanner $directoryScanner, PublishManager $publishManager)
    {
        parent::__construct();
        $this->directoryScanner = $directoryScanner;
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
        $this->directoryScanner->scan();
        $this->publishManager->sunchronyzeWithDb();
        $output->writeln('Done!');
    }
}