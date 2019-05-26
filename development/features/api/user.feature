Feature: API Access
  In order to access protected resource
  As an API client
  I need to be able to connect

  Scenario: Perform API call
    Given I retrieve a JWT token for user "admin" with password "admin"
    And I send a GET request to "api/users"
    Then the JSON node "root[0].username" should be equal to the string "admin"

  Scenario: Invalid access token
    Given I retrieve a JWT token for user "admin" with password "invalid"
    And I send a GET request to "api/users"
    Then the JSON nodes should contain:
      | code    | 401                 |
      | message | JWT Token not found |
