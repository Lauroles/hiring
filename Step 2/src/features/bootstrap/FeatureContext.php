<?php

use Behat\Behat\Context\Context;
use Domain\Model\Fleet;
use Domain\Model\Vehicle;
use Domain\Model\Location;
use Infra\Repository\InMemoryFleetRepository;
use Infra\Repository\InMemoryVehicleRepository;
use App\Handler\RegisterVehicleHandler;
use App\Handler\ParkVehicleHandler;
use App\Command\RegisterVehicleCommand;
use App\Command\ParkVehicleCommand;

class FeatureContext implements Context
{
    private $fleetRepository;
    private $vehicleRepository;
    private $registerVehicleHandler;
    private $parkVehicleHandler;
    private $response;
    private $fleet;
    private $otherUserFleet;
    private $vehicle;
    private $location;

    public function __construct()
    {
        $this->fleetRepository = new InMemoryFleetRepository();
        $this->vehicleRepository = new InMemoryVehicleRepository();
        $this->registerVehicleHandler = new RegisterVehicleHandler($this->fleetRepository, $this->vehicleRepository);
        $this->parkVehicleHandler = new ParkVehicleHandler($this->vehicleRepository);
    }

    /**
     * @Given I have a fleet
    */
    public function iHaveAFleet()
    {
        $this->fleet = new Fleet(uniqid());
        $this->fleetRepository->save($this->fleet);

        $savedFleet = $this->fleetRepository->findById($this->fleet->getId());
        if ($savedFleet === null) {
            throw new \Exception("Fleet no registered.");
        }
    }

    /**
     * @Given I have a vehicle with registration number :registrationNumber
    */
    public function iHaveAVehicleWithRegistrationNumber($registrationNumber)
    {
        $this->vehicle = new Vehicle(uniqid(), $registrationNumber);
        $this->vehicleRepository->save($this->vehicle);

        $savedCar = $this->vehicleRepository->findById($this->vehicle->getId());
        if ($savedCar === null) {
            throw new \Exception("Fleet not registered.");
        }
    }

    /**
     * @When I register this vehicle into my fleet
    */
    public function iRegisterThisVehicleIntoMyFleet()
    {
        try {
            $this->registerVehicleHandler->handle(new RegisterVehicleCommand($this->fleet->getId(), $this->vehicle->getId(), $this->vehicle->getRegistrationNumber()));
            $this->response = "registered";
        } catch (Exception $e) {
            $this->response = $e->getMessage();
        }
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
    */
    public function thisVehicleShouldBePartOfMyVehicleFleet()
    {
        if (!$this->fleet->isVehicleInFleet($this->vehicle)) {
            throw new Exception("Vehicle is not part of the fleet");
        }
    }

    /**
     * @When I try to register this vehicle into my fleet again
    */
    public function iTryToRegisterThisVehicleIntoMyFleetAgain()
    {
        $this->iRegisterThisVehicleIntoMyFleet();
    }

    /**
     * @Then I should be informed that this vehicle has already been registered into my fleet
    */
    public function iShouldBeInformedThatThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
    {
        if ($this->response !== "This vehicle has already been registered into the fleet.") {
            throw new Exception("Expected to be informed that the vehicle is already registered, but wasn't.");
        }
    }

    /**
     * @Given this vehicle has been registered into my fleet
    */
    public function thisVehicleHasBeenRegisteredIntoMyFleet()
    {
        if (!$this->fleet->isVehicleInFleet($this->vehicle)) {
            $this->fleet->addVehicle($this->vehicle);
            
            $this->fleetRepository->save($this->fleet);
        }
    }

    /**
     * @Given I have registered this vehicle into my fleet
    */
    public function iHaveRegisteredThisVehicleIntoMyFleet()
    {
        $this->registerVehicleHandler->handle(new RegisterVehicleCommand($this->fleet->getId(), $this->vehicle->getId(), $this->vehicle->getRegistrationNumber()));
    }

    /**
     * @Given I have a location with latitude :lat and longitude :lng
    */
    public function iHaveALocationWithLatitudeAndLongitude($lat, $lng)
    {
        $this->location = new Location($lat, $lng);
    }

    /**
     * @When I park my vehicle at this location
    */
    public function iParkMyVehicleAtThisLocation()
    {
        try {
            $command = new ParkVehicleCommand($this->vehicle->getRegistrationNumber(), $this->location->getLatitude(), $this->location->getLongitude());
            $this->parkVehicleHandler->handle($command);
            $this->response = "Vehicle parked successfully.";
        } catch (\Exception $e) {
            $this->response = $e->getMessage();
        }
    }

    /**
     * @Then the known location of my vehicle should verify this location
    */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation()
    {
        $vehicleLocation = $this->vehicle->getLocation();
        $expectedLocation = $this->location;
    
        // Compare les valeurs de latitude et longitude
        if ($vehicleLocation->getLatitude() !== $expectedLocation->getLatitude() ||
            $vehicleLocation->getLongitude() !== $expectedLocation->getLongitude()) {
            throw new Exception("The vehicle is not at the expected location.");
        }
    }    

    /**
     * @Given my vehicle has been parked into this location
    */
    public function myVehicleHasBeenParkedIntoThisLocation()
    {
        $this->iParkMyVehicleAtThisLocation();
    }

    /**
     * @When I try to park my vehicle at this location again
    */
    public function iTryToParkMyVehicleAtThisLocationAgain()
    {
        try {
            $command = new ParkVehicleCommand($this->vehicle->getRegistrationNumber(), $this->location->getLatitude(), $this->location->getLongitude());
            $this->parkVehicleHandler->handle($command);
            $this->response = "Vehicle parked successfully.";
        } catch (\Exception $e) {
            $this->response = $e->getMessage();
        }
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
    */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        if ($this->response !== "Vehicle is already parked at this location.") {
            throw new Exception("The expected message was not received.");
        }
    }

    /**
     * @Given another user has a fleet
    */
    public function anotherUserHasAFleet()
    {
        $this->otherUserFleet = new Fleet(uniqid());
        $this->fleetRepository->save($this->otherUserFleet);
    
        $savedFleet = $this->fleetRepository->findById($this->otherUserFleet->getId());
        if ($savedFleet === null) {
            throw new \Exception("Fleet not registered.");
        }
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
    */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet()
    {
        if (!$this->otherUserFleet->isVehicleInFleet($this->vehicle)) {
            $this->otherUserFleet->addVehicle($this->vehicle);
            
            $this->fleetRepository->save($this->otherUserFleet);
        }
    }
}
