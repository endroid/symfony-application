Feature: Admin

  Background:
    Given I am on "/login"
    And I fill in "_username" with "admin"
    And I fill in "_password" with "admin"
    And I press "_submit"

  Scenario: Dashboard
    And I should see "Users"
