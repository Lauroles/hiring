<?php
namespace App\Command;

class ParkVehicleCommand {
    private $vehicleId;
    private $latitude;
    private $longitude;

    public function __construct($vehicleId, $latitude, $longitude) {
        $this->vehicleId = $vehicleId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getVehicleId() {
        return $this->vehicleId;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }
}