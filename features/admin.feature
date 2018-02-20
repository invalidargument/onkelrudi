@admin
Feature: Administration page of onkelrudi
  In order to create new fleamarkets
  As an onkelrudi user in role admin
  I need to be able to create new Organizer and Fleamarket

  @javascript
  Scenario: Admin user is shown all fleamarkets of all users in his list
    Given I have a default organizer
    And I am slowly authenticated as user
    And I go to "/flohmarkt-anlegen/?test=1"
    When I fill in the following:
      | marketDate | 31.01.2019 |
      | marketTimeFrom | 09:30 |
      | marketTimeTo | 18:00 |
      | fleamarket_name | Mein USER Testflohmarkt |
      | fleamarket_description | Eine Beschreibung |
      | fleamarket_location | Zu Hause |
      | fleamarket_street | Hausstr. |
      | fleamarket_streetNo | 42 |
      | fleamarket_zipCode | 50000 |
      | fleamarket_city | Köln |
      | fleamarket_url | http://www.example.com |
      | organizer_name | Die Flohmarkt GmbH |
      | organizer_phone | 0221 1424567890 |
      | organizer_email | example@example.com |
      | organizer_url | http://www.example.com/foo |
      | organizer_street | Aachener Straße |
      | organizer_streetNo | 5000 |
      | organizer_zip | 5000 |
      | organizer_city | Köln |
    And I press "Neuen Termin speichern - click hier!"
    And I wait for "1" seconds
    Then I should see a ".button-success" element
    Then I go to "/logout/"
    Given I have an Organizer User with Email "info@onkel-rudi.de"
    When I am slowly authenticated as user "info@onkel-rudi.de"
    And I go to "/flohmarkt-anlegen/?test=1"
    When I fill in the following:
      | marketDate | 31.01.2019 |
      | marketTimeFrom | 09:30 |
      | marketTimeTo | 18:00 |
      | fleamarket_name | Mein ORGANIZER Testflohmarkt |
      | fleamarket_description | Eine Beschreibung |
      | fleamarket_location | Zu Hause |
      | fleamarket_street | Hausstr. |
      | fleamarket_streetNo | 42 |
      | fleamarket_zipCode | 50000 |
      | fleamarket_city | Köln |
      | fleamarket_url | http://www.example.com |
    And I press "Neuen Termin speichern - click hier!"
    And I wait for "1" seconds
    Then I should see a ".button-success" element
    Then I go to "/logout/"
    When I am slowly authenticated as user "admin@onkel-rudi.de"
    And I go to "/flohmarkt-anlegen/?test=1"
    When I fill in the following:
      | marketDate | 31.01.2019 |
      | marketTimeFrom | 09:30 |
      | marketTimeTo | 18:00 |
      | fleamarket_name | Mein ORGANIZER Testflohmarkt |
      | fleamarket_description | Eine Beschreibung |
      | fleamarket_location | Zu Hause |
      | fleamarket_street | Hausstr. |
      | fleamarket_streetNo | 42 |
      | fleamarket_zipCode | 50000 |
      | fleamarket_city | Köln |
      | fleamarket_url | http://www.example.com |
      | organizer_name | Der Admin Organizer |
    And I press "Neuen Termin speichern - click hier!"
    And I wait for "1" seconds
    Then I should see a ".button-success" element
    When I send a "GET" request to "http://localhost/public/api/v1/fleamarkets"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":[{"id":1,"uuid":"d1d8f25c-7567-5bbd-a09f-59ec85a9d90a","organizer":{"id":2,"uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"user":{"type":"User","identifier":"test@onkel-rudi.de","password":"","hasOptIn":""},"name":"Mein USER Testflohmarkt","description":"Eine Beschreibung","dates":[{"start":"2019-01-31 09:30:00","end":"2019-01-31 18:00:00"}],"street":"Hausstr.","streetNo":"42","city":"K\u00f6ln","zipCode":"50000","location":"Zu Hause","url":"http:\/\/www.example.com"},{"id":2,"uuid":"4abb0721-3cc5-55c5-9f3e-b17c4bd9e92b","organizer":{"id":1,"uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"user":{"type":"User","identifier":"info@onkel-rudi.de","password":"","hasOptIn":""},"name":"Mein ORGANIZER Testflohmarkt","description":"Eine Beschreibung","dates":[{"start":"2019-01-31 09:30:00","end":"2019-01-31 18:00:00"}],"street":"Hausstr.","streetNo":"42","city":"K\u00f6ln","zipCode":"50000","location":"Zu Hause","url":"http:\/\/www.example.com"},{"id":3,"uuid":"f9f7b33b-7f1f-592e-86e0-bf79ee797fcd","organizer":{"id":4,"uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"user":{"type":"User","identifier":"admin@onkel-rudi.de","password":"","hasOptIn":""},"name":"Mein ORGANIZER Testflohmarkt","description":"Eine Beschreibung","dates":[{"start":"2019-01-31 09:30:00","end":"2019-01-31 18:00:00"}],"street":"Hausstr.","streetNo":"42","city":"K\u00f6ln","zipCode":"50000","location":"Zu Hause","url":"http:\/\/www.example.com"}]}
    """
    Given I am slowly authenticated as user "test2@onkel-rudi.de"
    And I go to "/profil/"
    Then I should not see "Mein Testflohmarkt"
    And I should not see "Mein Testflohmarkt UPDATED"