Feature: API Access
  In order to access protected resource
  As an API client
  I need to be able to connect

  @login
  Scenario: Perform API call
    Given I send a GET request to "api/users"
    Then print last JSON response

#  Scenario: Invalid access token
#    Given I use an invalid access token
#    And I perform a search call
#    Then I should see an error message
