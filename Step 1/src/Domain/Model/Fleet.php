<?php
namespace Domain\Model;

class Fleet {
    private $id;
    private $vehicles = [];

    public function __construct(string $id) {
        $this->id = $id;
    }

    public function getId(): string {
        return $this->id;
    }

    public function addVehicle(Vehicle $vehicle) {
        if (!$this->isVehicleInFleet($vehicle)) {
            $this->vehicles[$vehicle->getId()] = $vehicle;
        }
    }

    public function isVehicleInFleet(Vehicle $vehicle) {
        return isset($this->vehicles[$vehicle->getId()]);
    }

    public function getVehicles() {
        return $this->vehicles;
    }
}