<?php
/**
 * author: abuchatskiy
 */

namespace App\Command;


use App\Service\PublishManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RepublishCommand extends Command
{
    /**
     * @var PublishManager
     */
    protected $publishManager;

    /**
     * RepublishCommand constructor.
     * @param PublishManager $publishManager
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(PublishManager $publishManager)
    {
        parent::__construct();
        $this->publishManager = $publishManager;
    }

    /**
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure(): void
    {
        $this
            ->setName('app:republish')
            ->setDescription('Republishes the photo source directory into the destination directory.')
            ->setHelp('This command republishes all the photos that are marker published in the DB');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \RuntimeException
     * @throws \League\Flysystem\FileExistsException
     * @throws \LogicException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \League\Flysystem\FileNotFoundException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->publishManager->republishAll();
        $output->writeln('Done!');
    }
}