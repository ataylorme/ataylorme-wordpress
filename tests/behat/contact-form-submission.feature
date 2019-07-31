@javascript @contact @no_auth
Feature: Verify the contact form
  As the site owner who likes to hear from users
  I want the contact form to submit properly

  Scenario: Confirm contact form submissions
    When I go to "/contact"
    And I set the contact form first name to "Andrew"
    And I set the contact form last name to "Taylor"
    And I set the contact form email to "andrew@pantheon.io"
    And I set the contact form message to "Testing the contact form with Behat!"
    When I submit the contact form
    Then I should see "Thanks for reaching out! I will be in touch with you shortly."