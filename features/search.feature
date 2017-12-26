Feature: Search
  In order to find specific content
  As a web user
  I need to be able to search the content

  Background:
    Given I am on "/"

  @javascript
  Scenario Outline:
    When I fill in "Search" with "<term>"
    And I press "Search"
    Then I should see "<result>"
    Examples:
      | term    | result  |
      | Endroid | Endroid |
      | Symfony | Symfony |
