@no_auth
Feature: HTTPS on the home page
  In order to have confidence that my site is secure
  As a site administrator
  I want to verify that HTTPS is enforced
  and the HSTS header is properly set

  Scenario: Verify HTTPS on the home page
    When I am on the homepage
    Then the current page is HTTPS

  @pantheon
  Scenario: Verify HSTS on the home page
    When I am on the homepage
    Then the "content-security-policy" response header equals "upgrade-insecure-requests"
    And the "strict-transport-security" response header value matches "/max-age=[0-9]+.*/"