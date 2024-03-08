<?php
namespace App\Query;

class GetVehicleLocationQuery {
    private $vehicleId;

    public function __construct($vehicleId) {
        $this->vehicleId = $vehicleId;
    }

    public function getVehicleId() {
        return $this->vehicleId;
    }
}