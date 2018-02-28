Feature: Mail
  In order to quickly navigate from emails to the application
  As a web user
  I need to be able to click email links and see the content

  Scenario: Clicking mail link
    Given my inbox is empty
    And I am on "/mail/send"
    And I wait 0.1 second
    Then the response status code should be 200
    And I should see an email with subject "This is the subject"

  Scenario:
    When I click the link "Call To Action" in the last received email
    Then the response status code should be 200
    Then I should see "Mail clicked"