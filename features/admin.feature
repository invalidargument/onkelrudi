@admin
Feature: Admin page of onkelrudi
  In order to create new fleamarkets
  As an onkelrudi user
  I need to be able to create new Organizer and Fleamarket

  @browser
  Scenario: Admin page is in place
    Given I am on "/admin/"
    Then I should see "+ Termin anlegen"