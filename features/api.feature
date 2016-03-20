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
    {"data":[{"id":"1","uuid":"7fdd31e2-7a5f-51a9-bec6-314cb78f9ecf","organizer":null,"name":"Der  #0 Flohmarkt von Rudi","description":"Ein toller Flohmarkt","dates":[{"start":"2016-12-12 08:01:02","end":"2016-12-13 20:20:20"}],"street":"Venloer","streetNo":"20000","city":"Cologne","zipCode":"5000","location":"Daheim","url":"http:\/\/www.example.com\/foo"},{"id":"2","uuid":"39bdc88d-31d8-592e-b77f-2281a21876f1","organizer":null,"name":"Der  #1 Flohmarkt von Rudi","description":"Ein toller Flohmarkt","dates":[{"start":"2016-12-12 08:01:02","end":"2016-12-13 20:20:20"}],"street":"Venloer","streetNo":"20000","city":"Cologne","zipCode":"5000","location":"Daheim","url":"http:\/\/www.example.com\/foo"},{"id":"3","uuid":"aa135915-9622-5e7a-ab51-22d8f8eecfd1","organizer":null,"name":"Der  #2 Flohmarkt von Rudi","description":"Ein toller Flohmarkt","dates":[{"start":"2016-12-12 08:01:02","end":"2016-12-13 20:20:20"}],"street":"Venloer","streetNo":"20000","city":"Cologne","zipCode":"5000","location":"Daheim","url":"http:\/\/www.example.com\/foo"}]}
    """

  Scenario: Get a single FleaMarket by id
    Given I have some fleamarkets
    And I send a "GET" request to "http://localhost/public/api/v1/fleamarkets/2"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":{"id":"2","uuid":"39bdc88d-31d8-592e-b77f-2281a21876f1","organizer":{"id":"2","uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"name":"Der  #1 Flohmarkt von Rudi","description":"Ein toller Flohmarkt","dates":[{"start":"2016-12-12 08:01:02","end":"2016-12-13 20:20:20"}],"street":"Venloer","streetNo":"20000","city":"Cologne","zipCode":"5000","location":"Daheim","url":"http:\/\/www.example.com\/foo"}}
    """

  Scenario: Create a new fleamarket
    Given I have a default organizer
    And I send a "POST" request to "http://localhost/public/api/v1/fleamarkets" with body
    """
    {"name":"Max Power", "description": "Blue Pants", "dates":[{"start":"2016-12-12 08:01:02","end":"2016-12-13 20:20:20"}], "start":"2015-01-01 00:00:00", "end":"2015-12-12 00:00:00", "zipCode":"50667"}
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
    {"data":{"id":"1","uuid":"14488af0-31e8-53e7-8899-7ab4ef0cd67b","organizer":{"id":"1","uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"name":"Max Power","description":"Blue Pants","dates":[{"start":"2016-12-12 08:01:02","end":"2016-12-13 20:20:20"}],"street":null,"streetNo":null,"city":null,"zipCode":"50667","location":null,"url":null}}
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
    {"data":{"id":"1","uuid":"7fdd31e2-7a5f-51a9-bec6-314cb78f9ecf","organizer":{"id":"1","uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"name":"Max UPDATED","description":"Blue Pants","dates":[{"start":"2016-12-12 08:01:02","end":"2016-12-13 20:20:20"}],"street":null,"streetNo":null,"city":null,"zipCode":"50667","location":null,"url":null}}
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
    {"data":{"id":"1","uuid":"83875c1f-c5b1-5078-81f8-faabcd87185b","name":"Max Power","street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null}}
    """

  Scenario: Get a single organizer by id
    Given I have a default organizer
    And I send a "GET" request to "http://localhost/public/api/v1/organizers/1"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":{"id":"1","uuid":"897b465a-3ba3-5aad-a014-0d7c443a8846","name":"Max Power","street":"foo","streetNo":"2000","zipCode":"50000","city":"K\u00f6ln","phone":"23","email":"defaultorganizer@example.com","url":"http:\/\/www.example.com"}}
    """

  Scenario: Get all existing organizers, limited by limit/offset
    Given I have some organizers
    And I send a "GET" request to "http://localhost/public/api/v1/organizers"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":[{"id":"1","uuid":"530f1f6b-1852-5a8e-84ee-a8619864e157","name":"Max Power #0","street":"foo","streetNo":"2000","zipCode":"50000","city":"K\u00f6ln","phone":"23","email":"foo@example.com","url":"http:\/\/www.example.com"},{"id":"2","uuid":"e6bdd9dd-e532-5047-a4b0-93b1f4d91325","name":"Max Power #1","street":"foo","streetNo":"2000","zipCode":"50000","city":"K\u00f6ln","phone":"23","email":"foo@example.com","url":"http:\/\/www.example.com"},{"id":"3","uuid":"9c80a1af-8965-549f-92ce-ce429988086e","name":"Max Power #2","street":"foo","streetNo":"2000","zipCode":"50000","city":"K\u00f6ln","phone":"23","email":"foo@example.com","url":"http:\/\/www.example.com"}]}
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
    {"data":{"id":"1","uuid":"897b465a-3ba3-5aad-a014-0d7c443a8846","name":"MAX POWERRRRR!!!!","street":"fuu","streetNo":"2001","zipCode":"50001","city":"K\u00f6ln","phone":"23","email":"defaultorganizer@example.com","url":"http:\/\/www.example.com"}}
    """

  Scenario: Create a new user
    Given I send a "POST" request to "http://localhost/public/api/v1/users" with body
    """
    {"email":"foo@example.com","password":"testtest","password_repeat":"testtest"}
    """
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":"0"}
    """
    Given I send a "POST" request to "http://localhost/public/api/v1/users" with body
    """
    {"email":"foo@example.com","password":"testtest","password_repeat":"testtest"}
    """
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"error":"Primary identifier already exists in database"}
    """