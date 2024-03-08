<?php
namespace App\Handler;

use Domain\Repository\FleetRepositoryInterface;
use Domain\Repository\VehicleRepositoryInterface;
use Domain\Model\Vehicle;
use App\Command\RegisterVehicleCommand;

class RegisterVehicleHandler {
    private $fleetRepository;
    private $vehicleRepository;

    public function __construct(FleetRepositoryInterface $fleetRepository, VehicleRepositoryInterface $vehicleRepository) {
        $this->fleetRepository = $fleetRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    public function handle(RegisterVehicleCommand $command) {
        $fleet = $this->fleetRepository->findById($command->getFleetId());
        $vehicle = $this->vehicleRepository->findById($command->getVehicleId());

        if (!$fleet || !$vehicle) {
            throw new \Exception("Fleet or vehicle not found.");
        }

        if ($fleet->isVehicleInFleet($vehicle)) {
            throw new \Exception("This vehicle has already been registered into the fleet.");
        }

        $fleet->addVehicle($vehicle);
        $this->fleetRepository->save($fleet);
    }
}