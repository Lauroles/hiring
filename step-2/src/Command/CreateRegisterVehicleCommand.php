<?php
namespace App\Command;

use App\Entity\Vehicle;
use App\Entity\Fleet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateRegisterVehicleCommand extends Command
{
    protected static $defaultName = 'fleet:register-vehicle';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Register a new vehicle.')
            ->addArgument('fleetID', InputArgument::REQUIRED, 'The ID of the fleet.')
            ->addArgument('registrationNumber', InputArgument::REQUIRED, 'The registration number of the vehicle.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fleetId = $input->getArgument('fleetID');
        $registrationNumber = $input->getArgument('registrationNumber');
    
        $fleet = $this->entityManager->getRepository(Fleet::class)->find($fleetId);
    
        if (!$fleet) {
            $output->writeln('No fleet found for ID '.$fleetId);
            return Command::FAILURE;
        }
    
        $vehicle = new Vehicle();
        $vehicle->setFleet($fleet);
        $vehicle->setRegistrationNumber($registrationNumber);
    
        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();
    
        $output->writeln('Vehicle registered with id: '.$vehicle->getId());
    
        return Command::SUCCESS;
    }
}
