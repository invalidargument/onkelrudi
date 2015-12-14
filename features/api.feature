Feature: API v1 fleamarkets
  In order to use the API for my services
  As an API user
  I need to be able to use the API in a REST way

  Scenario: Get all existing FleaMarkets, limited by limit/offset
    Given I have some fleamarkets in my database
    And I send a "GET" request to "http://localhost/public/api/v1/fleamarkets"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":[{"id":"1","organizer":null,"name":"Der  #0 Flohmarkt von Rudi","description":"Ein toller Flohmarkt","start":"2015-12-12 00:00:12","end":"2015-12-12 00:00:33","street":"Venloer","streetNo":"20000","city":"Cologne","zipCode":"5000","location":"Daheim","url":"http:\/\/www.example.com\/foo"},{"id":"2","organizer":null,"name":"Der  #1 Flohmarkt von Rudi","description":"Ein toller Flohmarkt","start":"2015-12-12 00:00:12","end":"2015-12-12 00:00:33","street":"Venloer","streetNo":"20000","city":"Cologne","zipCode":"5000","location":"Daheim","url":"http:\/\/www.example.com\/foo"},{"id":"3","organizer":null,"name":"Der  #2 Flohmarkt von Rudi","description":"Ein toller Flohmarkt","start":"2015-12-12 00:00:12","end":"2015-12-12 00:00:33","street":"Venloer","streetNo":"20000","city":"Cologne","zipCode":"5000","location":"Daheim","url":"http:\/\/www.example.com\/foo"}]}
    """

  Scenario: Get a single FleaMarket by id
    Given I have some fleamarkets in my database
    And I send a "GET" request to "http://localhost/public/api/v1/fleamarkets/2"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":{"id":"2","organizer":null,"name":"Der  #1 Flohmarkt von Rudi","description":"Ein toller Flohmarkt","start":"2015-12-12 00:00:12","end":"2015-12-12 00:00:33","street":"Venloer","streetNo":"20000","city":"Cologne","zipCode":"5000","location":"Daheim","url":"http:\/\/www.example.com\/foo"}}
    """

  Scenario: Create a new fleamarket
    Given I have a default organizer
    And I send a "POST" request to "http://localhost/public/api/v1/fleamarkets/%7B%22data%22%3A%7B%22name%22%3A%22Max+Power%22%2C+%22description%22%3A+%22Blue+Pants%22%2C+%22start%22%3A%222015-01-01+00%3A00%3A00%22%2C+%22end%22%3A%222015-12-12+00%3A00%3A00%22%2C+%22zipCode%22%3A%2250667%22%7D%7D"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":"1"}
    """
    Given I send a "GET" request to "http://localhost/public/api/v1/fleamarkets/1"
    Then the response should be
    """
    {"data":{"id":"1","organizer":null,"name":"Max Power","description":"Blue Pants","start":"2015-01-01 00:00:00","end":"2015-12-12 00:00:00","street":null,"streetNo":null,"city":null,"zipCode":"50667","location":null,"url":null}}
    """

  Scenario: Update an existing fleamarket
    Given I have some fleamarkets in my database
    And I send a "PUT" request to "http://localhost/public/api/v1/fleamarkets/%7B%22data%22%3A%7B%22name%22%3A%22Max+UPDATED%22%2C+%22description%22%3A+%22Blue+Pants%22%2C+%22start%22%3A%222015-01-01+00%3A00%3A00%22%2C+%22end%22%3A%222015-12-12+00%3A00%3A00%22%2C+%22zipCode%22%3A%2250667%22%2C+%22id%22%3A+%221%22%7D%7D"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":1}
    """
    Given I send a "GET" request to "http://localhost/public/api/v1/fleamarkets/1"
    Then the response should be
    """
    {"data":{"id":"1","organizer":null,"name":"Max UPDATED","description":"Blue Pants","start":"2015-01-01 00:00:00","end":"2015-12-12 00:00:00","street":null,"streetNo":null,"city":null,"zipCode":"50667","location":null,"url":null}}
    """
