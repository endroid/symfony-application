Feature: Show search results
  In order to enable users to search
  users should be able to visit the
  search page with a query

  Scenario: Show search results
    Given I am on "/search/?q=news"
    Then the response status code should be 200
    Then I should see "News article" in the "h2" element
