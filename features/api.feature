Feature: API v1 fleamarkets
  In order to use the API for my services
  As an API user
  I need to be able to use the API in a REST way

  Scenario: Get all existing FleaMarkets, limited by limit/offset
    Given I have some fleamarkets in my database
    And I send a "GET" request to "http://localhost/public/api/v1/fleamarkets"
    Then the response code should be "200"
    And the response should be json
    And the response should contain all created fleamarkets

  Scenario: Get a single FleaMarket by id
    Given I have some fleamarkets in my database
    And I send a "GET" request to "http://localhost/public/api/v1/fleamarkets/99"
    Then the response code should be "200"
    And the response should be json
    And the response should contain fleamarket with id "99"