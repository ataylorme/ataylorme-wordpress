@no_auth @cookie_notice
Feature: Visibility of the cookie notice
  In order to be compliant with GRDP
  As a site administrator
  I want to verify the cookie notice exists
  And can be accepted

  Scenario: Verify the cookie notice
    When I am on the homepage
    Then the cookie notice is shown
    And I accept the cookie notice
    Then the cookie notice is hidden
    
