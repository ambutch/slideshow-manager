<?php
/**
 * author: abuchatskiy
 */

namespace App\Command;


use App\Service\DirectoryScanner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ScanCommand
 * @package App\Command
 */
class ScanCommand extends Command
{
    /**
     * @var DirectoryScanner
     */
    protected $directoryScanner;

    /**
     * ScanCommand constructor.
     * @param DirectoryScanner $directoryScanner
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(DirectoryScanner $directoryScanner)
    {
        $this->directoryScanner = $directoryScanner;
        parent::__construct();
    }

    /**
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure(): void
    {
        $this
            ->setName('app:scan')
            ->setDescription('Scans the photo source directory.')
            ->setHelp('This command scans the photo source directory and updates the DB with actual data')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     * @throws \LogicException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \League\Flysystem\FileNotFoundException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->directoryScanner->scan();
        $output->writeln('Done!');
    }
}