Feature: API Access
  In order to access protected resource
  As an API client
  I need to be able to connect

  Scenario: Perform API call
    Given I retrieve a JWT token for user "admin"
    And I send a GET request to "api/examples"
    Then the JSON node "root[0].id" should be equal to the string "63bf0dd5-68df-4e2f-bcfe-b36583f0615e"
    And the JSON node "root[0].name" should be equal to the string "Example 1"

  Scenario: Invalid access token
    Given I use JWT token "invalid"
    And I send a GET request to "api/examples"
    Then the JSON nodes should contain:
      | code    | 401               |
      | message | Invalid JWT Token |
