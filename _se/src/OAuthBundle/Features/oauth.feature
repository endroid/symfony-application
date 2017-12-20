Feature: OAuth authentication mechanism
  In order to demonstrate the authentication
  mechanism works, users should be able to
  retrieve an access token and access the
  secured area.

  Scenario: Retrieve an access token
    Given I create a client
    When I retrieve an access token
    Then I have an access token

  Scenario: Call with invalid access token
    Given I have an invalid access token
    When I go to "/api/articles.json"
    Then the response status code should be 401

  Scenario: Call with valid access token
    Given I have a valid access token
    When I set the authorization header
    And I go to "/api/articles.json"
    Then the response status code should be 200
    And the response should contain "slug"
