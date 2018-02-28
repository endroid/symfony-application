Feature: Admin
  In order to administer the application
  As a web user
  I need to be able to login

  Scenario: EasyAdmin login
    Given I am on "/easy-admin"
    And I fill in "Username" with "superadmin"
    And I fill in "Password" with "superadmin"
    And I press "Log in"
    Then I should see "EasyAdmin"

  Scenario: Sonata Admin login
    Given I am on "/sonata-admin"
    And I fill in "Username" with "superadmin"
    And I fill in "Password" with "superadmin"
    And I press "Log in"
    Then I should see "Sonata Admin"

  Scenario: Default login
    Given I am on "/login"
    And I fill in "Username" with "superadmin"
    And I fill in "Password" with "superadmin"
    And I press "Log in"
    Then I should see "Log out"

  Scenario: Incorrect login
    Given I am on "/login"
    And I fill in "Username" with "incorrect"
    And I fill in "Password" with "incorrect"
    And I press "Log in"
    Then I should see "Invalid credentials"