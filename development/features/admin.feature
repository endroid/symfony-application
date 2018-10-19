Feature: Admin

  Background:
    Given I am on "/login"
    And I fill in "_username" with "admin"
    And I fill in "_password" with "admin"
    And I press "_submit"

  Scenario: Sonata Admin
    And I should see "Users"
    And I should see "Groups"

  Scenario: Easy Admin
    When I am on "/easy-admin"
    And I should see "Add Example"
