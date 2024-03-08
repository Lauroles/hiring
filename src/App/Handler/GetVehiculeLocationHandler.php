<?php
namespace App\Handler;

use Domain\Repository\VehicleRepositoryInterface;
use App\Query\GetVehicleLocationQuery;

class GetVehicleLocationHandler {
    private $vehicleRepository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository) {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function handle(GetVehicleLocationQuery $query) {
        $vehicle = $this->vehicleRepository->findByRegistrationNumber($query->getVehicleId());

        if (!$vehicle) {
            throw new \Exception("Vehicle not found.");
        }

        return $vehicle->getLocation();
    }
}