<?php
namespace Domain\Model;

class Vehicle {
    private $id;
    private $registrationNumber;
    private $location;

    public function __construct($id, $registrationNumber) {
        $this->id = $id;
        $this->registrationNumber = $registrationNumber;
        $this->location = null;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getRegistrationNumber() {
        return $this->registrationNumber;
    }

    public function setLocation(Location $location) {
        $this->location = $location;
    }

    public function getLocation(): ?Location {
        return $this->location;
    }
}
