Feature: Register a vehicle

  In order to follow many vehicles with my application
  As an application user
  I should be able to register my vehicle

  Scenario: I can register a vehicle
    Given I have a fleet
    And I have a vehicle with registration number "ABC123"
    When I register this vehicle into my fleet
    Then this vehicle should be part of my vehicle fleet

  Scenario: I can't register same vehicle twice
    Given I have a fleet
    And I have a vehicle with registration number "ABC123"
    And this vehicle has been registered into my fleet
    When I try to register this vehicle into my fleet again
    Then I should be informed that this vehicle has already been registered into my fleet

  Scenario: Same vehicle can belong to more than one fleet
    Given I have a fleet
    And another user has a fleet
    And I have a vehicle with registration number "XYZ789"
    And this vehicle has been registered into the other user's fleet
    When I register this vehicle into my fleet
    Then this vehicle should be part of my vehicle fleet