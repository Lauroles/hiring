<?php
namespace App\Command;

use App\Entity\Location;
use App\Entity\Vehicle;
use App\Entity\Fleet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateLocalizeVehicleCommand extends Command
{
    protected static $defaultName = 'fleet:localize-vehicle';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Localize vehicle.')
            ->addArgument('fleetId', InputArgument::REQUIRED,'The fleet ID')
            ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED,'The vehicle plate number')
            ->addArgument('lat', InputArgument::REQUIRED, 'Latitude')
            ->addArgument('lng', InputArgument::REQUIRED, 'Longitude')
            ->addArgument('alt', InputArgument::OPTIONAL, 'Altitude');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fleetId = $input->getArgument('fleetId');
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');
        $lat = $input->getArgument('lat');
        $lng = $input->getArgument('lng');
        $alt = $input->getArgument('alt');
    
        $fleet = $this->entityManager->getRepository(Fleet::class)->find($fleetId);
        $vehicle = $this->entityManager->getRepository(Vehicle::class)->findOneBy([
            'registrationNumber' => $vehiclePlateNumber,
            'fleet' => $fleet
        ]);
            
        if (!$vehicle) {
            $output->writeln('No vehicle found for plate number '.$vehiclePlateNumber.' in this fleet.');
            return Command::FAILURE;
        }
    
        $location = new Location();
        $location->setVehicle($vehicle);
        $location->setLatitude($lat);
        $location->setLongitude($lng);
        if ($alt) {
            $location->setAltitude($alt);
        }
    
        $this->entityManager->persist($location);
        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();
    
        $output->writeln('Vehicle localized with id: '.$vehicle->getId());
    
        return Command::SUCCESS;
    }
}