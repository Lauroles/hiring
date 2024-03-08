<?php

require_once 'vendor/autoload.php';

use Domain\Model\Vehicle;
use Domain\Model\Fleet;
use Domain\Model\Location;
use Infra\Repository\InMemoryFleetRepository;
use Infra\Repository\InMemoryVehicleRepository;
use App\Command\RegisterVehicleCommand;
use App\Command\ParkVehicleCommand;
use App\Handler\RegisterVehicleHandler;
use App\Handler\ParkVehicleHandler;

$fleetRepository = new InMemoryFleetRepository();
$vehicleRepository = new InMemoryVehicleRepository();

// Créer une flotte
$fleet = new Fleet("123");
$fleetRepository->save($fleet);

// Créer et enregistrer un véhicule
$vehicle = new Vehicle("1", "ABC123"); // Supposons que "1" soit l'ID unique du véhicule
$vehicleRepository->save($vehicle); // Assurez-vous que cette méthode existe et fonctionne comme attendu

// Enregistrer un véhicule dans la flotte
$registerCommand = new RegisterVehicleCommand("123", "1", "ABC123");
$registerHandler = new RegisterVehicleHandler($fleetRepository, $vehicleRepository);
try {
    $registerHandler->handle($registerCommand);
    echo "Le véhicule a été enregistré dans la flotte.\n\n";
} catch (Exception $e) {
    echo "Erreur lors de l'enregistrement du véhicule : " . $e->getMessage() . "\n\n";
}

// Stationner le véhicule
$parkCommand = new ParkVehicleCommand("ABC123", 48.8566, 2.3522); // Coordonnées de Paris
$parkHandler = new ParkVehicleHandler($vehicleRepository);
$parkHandler->handle($parkCommand);

// Récupérer le véhicule et afficher sa localisation
$vehicle = $vehicleRepository->findByRegistrationNumber("ABC123");
$location = $vehicle->getLocation();
echo "Le véhicule est stationné à la latitude : " . $location->getLatitude() . " et longitude : " . $location->getLongitude();