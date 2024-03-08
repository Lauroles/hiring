<?php
namespace Domain\Repository;

use Domain\Model\Vehicle;

interface VehicleRepositoryInterface {
    public function save(Vehicle $vehicle);
    public function findByRegistrationNumber($registrationNumber): ?Vehicle;
    public function findById($id): ?Vehicle;
    public function findAll(): array;
}
