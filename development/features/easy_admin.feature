Feature: Easy Admin

  Background:
    Given I am on "/login"
    And I fill in "_username" with "admin"
    And I fill in "_password" with "admin"
    And I press "_submit"

  Scenario: Easy Admin
    When I am on "/easy-admin"
    And I should see "Add Example"

  Scenario: Not logged in
    When I am on "/logout"
    And I am on "/easy-admin"
    Then I should see "Log in"
    