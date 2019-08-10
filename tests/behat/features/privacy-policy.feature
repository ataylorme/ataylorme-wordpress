@no_auth @privacy
Feature: Visibility of the privacy policy
  In order to be in compliance with privacy laws
  As a site administrator
  I want to verify the privacy policy

Background:
  Given I am an anonymous user

  Scenario: Verify the privacy policy is accessible from the homepage
    When I am on the homepage
    And I follow "Privacy Policy"
    Then the response status code should be 200
    And I should see "This website is the personal, non-commercial website of Andrew Taylor."
    And I should see "Contact forms"
    And I should see "Cookies"
    And I should see "Comments"
    And I should see "User accounts"
