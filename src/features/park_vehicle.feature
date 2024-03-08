Feature: Park a vehicle

  In order to not forget where I've parked my vehicle
  As an application user
  I should be able to indicate my vehicle location

  Background:
    Given I have a fleet
    And I have a vehicle with registration number "ABC123"
    And I have registered this vehicle into my fleet

  Scenario: Successfully park a vehicle
    Given I have a location with latitude "48.8566" and longitude "2.3522"
    When I park my vehicle at this location
    Then the known location of my vehicle should verify this location

  Scenario: Can't localize my vehicle to the same location two times in a row
    Given I have a location with latitude "48.8566" and longitude "2.3522"
    And my vehicle has been parked into this location
    When I try to park my vehicle at this location again
    Then I should be informed that my vehicle is already parked at this location