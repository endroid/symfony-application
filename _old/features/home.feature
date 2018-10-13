Feature: Home
  In order to visit the start page of the application
  As a web user
  I need to be able to reach home

  Scenario: Visiting home
    And I am on "/"
    Then I should see "Home"
    And the response status code should be 200