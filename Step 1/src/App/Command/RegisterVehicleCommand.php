<?php
namespace App\Command;

class RegisterVehicleCommand {
    private $fleetId;
    private $vehicleId;
    private $registrationNumber;

    public function __construct($fleetId, $vehicleId, $registrationNumber) {
        $this->fleetId = $fleetId;
        $this->vehicleId = $vehicleId;
        $this->registrationNumber = $registrationNumber;
    }

    public function getFleetId() {
        return $this->fleetId;
    }

    public function getVehicleId() {
        return $this->vehicleId;
    }

    public function getRegistrationNumber() {
        return $this->registrationNumber;
    }
}