@auth
Feature: Login as an administrator
  As a maintainer of the site
  I want basic login behavior to work
  So that I can administer the site

Background:
    Given I am a WordPress admin
    Given I am on the WordPress dashboard

  Scenario: Confirm access to create users
    When I go to the "Users > Add New" menu
    Then I should see "Add New User"