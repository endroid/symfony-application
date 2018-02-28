Feature: User
  In order to allow for private pages
  As a logged in web user
  I need to be able to see secured content

  Background:
    Given I am logged in as "info@endroid.nl"

  @javascript
  Scenario: EasyAdmin visit
    And I am on "/easy-admin/?action=list&entity=User"
    Then I should see "EasyAdmin"
