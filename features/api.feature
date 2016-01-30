Feature: API v1 fleamarkets
  In order to use the API for my services
  As an API user
  I need to be able to use the API in a REST way

  Scenario: Get all existing FleaMarkets, limited by limit/offset
    Given I have some fleamarkets
    And I send a "GET" request to "http://localhost/public/api/v1/fleamarkets"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":[{"id":"1","uuid":"99448e9a-b780-53ec-8143-255473192537","organizer":null,"name":"Der  #0 Flohmarkt von Rudi","description":"Ein toller Flohmarkt","start":"2016-03-12 08:00:12","end":"2016-03-12 19:30:33","street":"Venloer","streetNo":"20000","city":"Cologne","zipCode":"5000","location":"Daheim","url":"http:\/\/www.example.com\/foo"},{"id":"2","uuid":"7e318e08-24a6-5be1-88be-ddffb9e10222","organizer":null,"name":"Der  #1 Flohmarkt von Rudi","description":"Ein toller Flohmarkt","start":"2016-03-12 08:00:12","end":"2016-03-12 19:30:33","street":"Venloer","streetNo":"20000","city":"Cologne","zipCode":"5000","location":"Daheim","url":"http:\/\/www.example.com\/foo"},{"id":"3","uuid":"dfb80ebc-0f53-5ac4-90ec-414f87b947de","organizer":null,"name":"Der  #2 Flohmarkt von Rudi","description":"Ein toller Flohmarkt","start":"2016-03-12 08:00:12","end":"2016-03-12 19:30:33","street":"Venloer","streetNo":"20000","city":"Cologne","zipCode":"5000","location":"Daheim","url":"http:\/\/www.example.com\/foo"}]}
    """

  Scenario: Get a single FleaMarket by id
    Given I have some fleamarkets
    And I send a "GET" request to "http://localhost/public/api/v1/fleamarkets/2"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":{"id":"2","uuid":"7e318e08-24a6-5be1-88be-ddffb9e10222","organizer":null,"name":"Der  #1 Flohmarkt von Rudi","description":"Ein toller Flohmarkt","dates":[{"start":"2016-12-12 08:01:02","end":"2016-12-13 20:20:20"}],"start":"2016-03-12 08:00:12","end":"2016-03-12 19:30:33","street":"Venloer","streetNo":"20000","city":"Cologne","zipCode":"5000","location":"Daheim","url":"http:\/\/www.example.com\/foo"}}
    """

  Scenario: Create a new fleamarket
    Given I have a default organizer
    And I send a "POST" request to "http://localhost/public/api/v1/fleamarkets" with body
    """
    {"name":"Max Power", "description": "Blue Pants", "start":"2015-01-01 00:00:00", "end":"2015-12-12 00:00:00", "dates":[], "zipCode":"50667"}
    """
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":"1"}
    """
    Given I send a "GET" request to "http://localhost/public/api/v1/fleamarkets/1"
    Then the response should be
    """
    {"data":{"id":"1","uuid":"b5920ca9-0bd6-5466-95b9-79a7c0532a91","organizer":null,"name":"Max Power","description":"Blue Pants","start":"2015-01-01 00:00:00","end":"2015-12-12 00:00:00","street":null,"streetNo":null,"city":null,"zipCode":"50667","location":null,"url":null}}
    """

  Scenario: Delete an existing fleamarket
    Given I have some fleamarkets
    And I send a "DELETE" request to "http://localhost/public/api/v1/fleamarkets/1"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":1}
    """

  Scenario: Update an item by id with data sent in body
    Given I have some fleamarkets
    And I send a "PUT" request to "http://localhost/public/api/v1/fleamarkets/1" with body
    """
    {"name":"Max UPDATED", "description": "Blue Pants", "start":"2015-01-01 00:00:00", "end":"2015-12-12 00:00:00", "zipCode":"50667"}
    """
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":1}
    """
    Given I send a "GET" request to "http://localhost/public/api/v1/fleamarkets/1"
    Then the response should be
    """
    {"data":{"id":"1","uuid":"99448e9a-b780-53ec-8143-255473192537","organizer":null,"name":"Max UPDATED","description":"Blue Pants","start":"2015-01-01 00:00:00","end":"2015-12-12 00:00:00","street":null,"streetNo":null,"city":null,"zipCode":"50667","location":null,"url":null}}
    """

  Scenario: Create a new organizer
    Given I send a "POST" request to "http://localhost/public/api/v1/organizers" with body
    """
    {"name":"Max Power"}
    """
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":"1"}
    """
    Given I send a "GET" request to "http://localhost/public/api/v1/organizers/1"
    Then the response should be
    """
    {"data":{"id":"1","uuid":"83875c1f-c5b1-5078-81f8-faabcd87185b","name":"Max Power","street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"url":null}}
    """

  Scenario: Get a single organizer by id
    Given I have a default organizer
    And I send a "GET" request to "http://localhost/public/api/v1/organizers/1"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":{"id":"1","uuid":"11c82a2c-058b-5ba4-ac87-927dbc2c2e03","name":"Max Power","street":"foo","streetNo":"2000","zipCode":"50000","city":"K\u00f6ln","phone":"23","url":"http:\/\/www.example.com"}}
    """

  Scenario: Get all existing organizers, limited by limit/offset
    Given I have some organizers
    And I send a "GET" request to "http://localhost/public/api/v1/organizers"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":[{"id":"1","uuid":"86400145-5035-5d35-b4c8-36117c812526","name":"Max Power #0","street":"foo","streetNo":"2000","zipCode":"50000","city":"K\u00f6ln","phone":"23","url":"http:\/\/www.example.com"},{"id":"2","uuid":"6a605d44-cfec-5261-8ba0-7d842b702121","name":"Max Power #1","street":"foo","streetNo":"2000","zipCode":"50000","city":"K\u00f6ln","phone":"23","url":"http:\/\/www.example.com"},{"id":"3","uuid":"8512dbb2-1035-57e5-9227-a70f9acde46b","name":"Max Power #2","street":"foo","streetNo":"2000","zipCode":"50000","city":"K\u00f6ln","phone":"23","url":"http:\/\/www.example.com"}]}
    """

  Scenario: Update an organizer by id
    Given I have a default organizer
    And I send a "PUT" request to "http://localhost/public/api/v1/organizers/1" with body
    """
    {"name":"MAX POWERRRRR!!!!","street":"fuu","streetNo":"2001","zipCode":"50001","city":"K\u00f6ln","phone":"23","url":"http:\/\/www.example.com"}
    """
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":1}
    """
    When I send a "GET" request to "http://localhost/public/api/v1/organizers/1"
    Then the response should be
    """
    {"data":{"id":"1","uuid":"11c82a2c-058b-5ba4-ac87-927dbc2c2e03","name":"MAX POWERRRRR!!!!","street":"fuu","streetNo":"2001","zipCode":"50001","city":"K\u00f6ln","phone":"23","url":"http:\/\/www.example.com"}}
    """