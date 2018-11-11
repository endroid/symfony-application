Feature: Sonata Admin

  Background:
    Given I am on "/login"
    And I fill in "_username" with "admin"
    And I fill in "_password" with "admin"
    And I press "_submit"

  Scenario: Sonata Admin
    And I should see "Users"
    And I should see "Groups"

  Scenario: Not logged in
    When I am on "/logout"
    And I am on "/admin/dashboard"
    Then I should see "Log in"
