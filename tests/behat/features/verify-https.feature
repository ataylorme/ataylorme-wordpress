@no_auth
Feature: HTTPS on the home page
  In order to have confidence that my site is secure
  As a site administrator
  I want to verify that HTTPS is enforced

  Scenario: Verify HSTS on the home page
    When I am on the homepage
    Then the "strict-transport-security" response header exists
    And the "strict-transport-security" response header matches "/max-age=[0-9]+; preload/"
    And the "content-security-policy" response header exists
    And the "content-security-policy" response header is "upgrade-insecure-requests"

  Scenario: Verify HTTPS on the home page
    When I am on the homepage
    Then the url should match "/^https/"