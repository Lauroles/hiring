<?php
namespace App\Handler;

use Domain\Repository\VehicleRepositoryInterface;
use Domain\Model\Location;
use App\Command\ParkVehicleCommand;

class ParkVehicleHandler {
    private $vehicleRepository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository) {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function handle(ParkVehicleCommand $command) {
        $vehicle = $this->vehicleRepository->findByRegistrationNumber($command->getVehicleId());

        if (!$vehicle) {
            throw new \Exception("Vehicle not found.");
        }

        $newLocation = new Location($command->getLatitude(), $command->getLongitude());
        $currentLocation = $vehicle->getLocation();

        if ($currentLocation && $currentLocation->equals($newLocation)) {
            throw new \Exception("Vehicle is already parked at this location.");
        }

        $vehicle->setLocation($newLocation);
        $this->vehicleRepository->save($vehicle);
    }
}