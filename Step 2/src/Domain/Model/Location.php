<?php
namespace Domain\Model;

class Location {
    private $latitude;
    private $longitude;

    public function __construct($latitude, $longitude) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    // Getters
    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function equals(Location $otherLocation): bool {
        return $this->latitude === $otherLocation->getLatitude() && $this->longitude === $otherLocation->getLongitude();
    }
}
