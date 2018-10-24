Feature: Generate PDF
  In order to demonstrate PDF generation
  users should be able to visit the URL
  and retrieve a resource of the type PDF

  Scenario: Generate PDF
    Given I am on "/pdf"
    Then the response status code should be 200
    Then the header "content-type" should be equal to "application/pdf;charset=utff-8"
