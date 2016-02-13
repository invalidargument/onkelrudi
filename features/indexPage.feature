Feature: Index page of onkelrudi
  In order to see enough information
  As an onkelrudi user
  I need to be able to call the index page and see some useful information

  @browser
  Scenario: Navigation is in place with wordpress content
    Given I am on "/"
    Then I should see "Termine" in the ".pure-menu-list li" element

  @browser
  Scenario: Startpage with fleamarket boxes is displayed
    Given I have some fleamarkets
    And I am on "/"
    Then I should see "Onkel Rudi" in the "h1" element
    And I should see a ".marketSummaryBox:nth-of-type(3)" element
    And I should see "Der #0 Flohmarkt von Rudi" in the ".marketSummaryBox:nth-of-type(3)" element
    When I follow "Der #2 Flohmarkt von Rudi"
    Then I should be on "/der-2-flohmarkt-von-rudi/termin/3"

  @browser
  Scenario: Detailview of a single fleamarket
    Given I have some fleamarkets
    And I am on "/der-2-flohmarkt-von-rudi/termin/3"
    Then I should see "Der #2 Flohmarkt von Rudi"
    And I should see a ".mapsLocation iframe" element