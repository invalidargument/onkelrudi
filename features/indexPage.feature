@indexPage
Feature: Index page of onkelrudi
  In order to see enough information
  As an onkelrudi user
  I need to be able to call the index page and see some useful information

  Scenario: Navigation is in place with wordpress content
    Given I am on "/"
    And I should see "Blog" in the ".pure-menu-list li:nth-of-type(1)" element
    And I should see "About/Impressum" in the ".footer .pure-menu-list li:nth-of-type(1)" element

  Scenario: Startpage with fleamarket boxes is displayed
    Given I have some fleamarkets within the upcoming timespan
    And I am on "/?test=1"
    Then I should see "Onkel Rudi" in the "h1" element
    And I should see "Der #2 Flohmarkt von Rudi" in the "div.marketSummaryBox:nth-of-type(3) h3" element
    When I follow "Alle Details zu "
    Then the url should match "/der-0-flohmarkt-von-rudi-cologne/termin/1/datum/\d+\.\d+\.\d+"

  Scenario: Detailview of a single fleamarket
    Given I have some fleamarkets
    And I am on "/der-2-flohmarkt-von-rudi/termin/3"
    Then I should see "Der #2 Flohmarkt von Rudi"
    And I should see a ".mapsLocation iframe" element

  Scenario: Fleamarket with expired dates shows a notice
    Given I have an expired fleamarket
    And I am on "/der-0-flohmarkt-von-rudi/termin/1"
    Then I should see "Der #0 Flohmarkt von Rudi"
    And I should see "Dieser Kinderflohmarkt hat bereits stattgefunden! Aktuell ist kein weiterer Termin eingetragen." in the ".expired" element