<?php
namespace Infra\Repository;

use Domain\Model\Vehicle;
use Domain\Repository\VehicleRepositoryInterface;

class InMemoryVehicleRepository implements VehicleRepositoryInterface {
    private $vehicles = [];
    private $idToRegistration = [];

    public function __construct() {
        $this->vehicles = [];
    }

    public function save(Vehicle $vehicle) {
        $this->vehicles[$vehicle->getRegistrationNumber()] = $vehicle;
        $this->idToRegistration[$vehicle->getId()] = $vehicle->getRegistrationNumber();
    }
    public function findByRegistrationNumber($registrationNumber): ?Vehicle {
        return $this->vehicles[$registrationNumber] ?? null;
    }

    public function findById($id): ?Vehicle {
        $registrationNumber = $this->idToRegistration[$id] ?? null;
        if ($registrationNumber) {
            return $this->findByRegistrationNumber($registrationNumber);
        }
        return null;
    }
    
    public function findAll(): array {
        return array_values($this->vehicles);
    }
}