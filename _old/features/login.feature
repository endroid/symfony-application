Feature: Admin
  In order to administer the application
  As a web user
  I need to be able to login

  Background:
    Given I am on "/login"
    And I fill in "Username" with "superadmin"
    And I fill in "Password" with "superadmin"
    And I press "Log in"

  Scenario: Show easy admin
    And I am on "/easy-admin/"
    Then I should see "EasyAdmin"

  Scenario: Show Sonata Admin
    And I am on "/sonata-admin/"
    Then I should see "Sonata Admin"

  Scenario:
    And I follow "Log out"
    And I am on "/login"
    And I fill in "Username" with "incorrect"
    And I fill in "Password" with "incorrect"
    And I press "Log in"
    Then I should see "Invalid credentials"