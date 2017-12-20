Feature:
  In order to moderate news
  As an API client
  I need to be able to create articles

  Scenario: Create an article
    Given I have the payload:
      """
        {
          "title": "Title",
          "content": "Content",
          "locale": "nl_NL"
        }
      """
    When I request "POST /api/articles"
    Then the response status code should be 201
    And the "Location" header should be "/api/articles/1"
    And the "title" property should equal "Title"
