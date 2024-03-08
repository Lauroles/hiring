<?php
namespace App\Command;

use App\Entity\Fleet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateFleetCommand extends Command
{
    protected static $defaultName = 'fleet:create';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new fleet.')
            ->addArgument('userId', InputArgument::REQUIRED, 'The ID of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userId = $input->getArgument('userId');
        $fleet = new Fleet();
        $fleet->setUserId($userId);

        $this->entityManager->persist($fleet);
        $this->entityManager->flush();

        $output->writeln('Fleet created with ID: '.$fleet->getId());

        return Command::SUCCESS;
    }
}
