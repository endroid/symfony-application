Feature: API Access
  In order to access protected resource
  As an API client
  I need to be able to connect

  Scenario: Perform API call
    Given I retrieve a JWT token for user "superadmin"
    And I send a GET request to "api/users"
    Then the JSON nodes should contain:
      | root[0].username | superadmin |

  Scenario: Invalid access token
    Given I use JWT token "invalid"
    And I send a GET request to "api/users"
    Then the JSON nodes should contain:
      | code | 401 |
      | message | Invalid JWT Token |
