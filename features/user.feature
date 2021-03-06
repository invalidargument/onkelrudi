@user
Feature: Administration page of onkelrudi
  In order to create new fleamarkets
  As an onkelrudi user in role user
  I need to be able to create a Fleamarket with corresponding organizer data

  @javascript
  Scenario: User can create a new fleamarket with a new organizer and update the data again
    Given I have a default organizer
    And I am slowly authenticated as user
    And I go to "/flohmarkt-anlegen/?test=1"
    Then I should see "Veröffentliche hier deine Flohmarkt-Termine!"
    When I fill in the following:
      | fleamarket_name | Rudi Bieller |
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
      | marketDate | 31.01.2019 |
      | marketTimeFrom | 09:30 |
      | marketTimeTo | 18:00 |
    And I check "acceptDataProcessing"
    And I press "Neuen Termin speichern - click hier!"
    And I wait for "1" seconds
    Then I should see a ".button-success" element
    And I should not see an ".error" element
    And I should see "Danke - Dein Termin wurde erfolgreich angelegt!"
    When I send a "GET" request to "http://localhost/public/api/v1/fleamarkets/1"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":{"id":1,"uuid":"ca18494a-05ba-57a9-8c1f-d980aeec9a5d","organizer":{"id":2,"uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"user":null,"name":"Rudi Bieller","description":"Eine Beschreibung","dates":[{"start":"2019-01-31 09:30:00","end":"2019-01-31 18:00:00"}],"street":"Hausstr.","streetNo":"42","city":"K\u00f6ln","zipCode":"50000","location":"Zu Hause","url":"http:\/\/www.example.com"}}
    """
    When I send a "GET" request to "http://localhost/public/api/v1/organizers/2"
    Then the response should be
    """
    {"data":{"id":2,"uuid":"1d8a8e24-946c-57b9-be63-a730f281cc17","name":"Die Flohmarkt GmbH","street":"Aachener Stra\u00dfe","streetNo":"5000","zipCode":"5000","city":"K\u00f6ln","phone":"0221 1424567890","email":"example@example.com","url":"http:\/\/www.example.com\/foo"}}
    """
    When I go to "flohmarkt-bearbeiten/1?test=1"
    And I fill in the following:
      | fleamarket_name | Mein Testflohmarkt UPDATED |
      | fleamarket_description | Eine Beschreibung UPDATED |
      | fleamarket_location | Zu Hause UPDATED |
      | fleamarket_street | Hausstr. UPDATED |
      | fleamarket_streetNo | 42000 |
      | fleamarket_zipCode | 55555 |
      | fleamarket_city | Köln UPDATED |
      | fleamarket_url | http://www.example.com/UPDATED |
      | organizer_name | Die Flohmarkt GmbH UPDATED |
      | organizer_phone | 0221 00000 |
      | organizer_email | UPDATED@example.com |
      | organizer_url | http://www.example.com/foo/UPDATED |
      | organizer_street | Aachener Straße UPDATED |
      | organizer_streetNo | 5555 |
      | organizer_zip | 666666 |
      | organizer_city | Köln UPDATED |
    And I check "acceptDataProcessing"
    And I press "Änderungen speichern - click hier!"
    And I wait for "1" seconds
    Then I should see a ".button-success" element
    And I should see "Dein Termin wurde erfolgreich aktualisiert!"
    When I send a "GET" request to "http://localhost/public/api/v1/fleamarkets/1"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":{"id":1,"uuid":"ca18494a-05ba-57a9-8c1f-d980aeec9a5d","organizer":{"id":2,"uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"user":null,"name":"Mein Testflohmarkt UPDATED","description":"Eine Beschreibung UPDATED","dates":[{"start":"2019-01-31 09:30:00","end":"2019-01-31 18:00:00"}],"street":"Hausstr. UPDATED","streetNo":"42000","city":"K\u00f6ln UPDATED","zipCode":"55555","location":"Zu Hause UPDATED","url":"http:\/\/www.example.com\/UPDATED"}}
    """
    When I send a "GET" request to "http://localhost/public/api/v1/organizers/2"
    Then the response should be
    """
    {"data":{"id":2,"uuid":"1d8a8e24-946c-57b9-be63-a730f281cc17","name":"Die Flohmarkt GmbH UPDATED","street":"Aachener Stra\u00dfe UPDATED","streetNo":"5555","zipCode":"666666","city":"K\u00f6ln UPDATED","phone":"0221 00000","email":"UPDATED@example.com","url":"http:\/\/www.example.com\/foo\/UPDATED"}}
    """

  @javascript
  Scenario: User can not create a new fleamarket when no existing organizer is selected and no new organizer data provided
    Given I am slowly authenticated as user
    And I am on "/flohmarkt-anlegen/?test=1"
    Then I should see "Veröffentliche hier deine Flohmarkt-Termine!"
    When I fill in the following:
      | fleamarket_name | Rudi Bieller |
      | fleamarket_description | Eine Beschreibung |
      | fleamarket_location | Zu Hause |
      | fleamarket_street | Hausstr. |
      | fleamarket_streetNo | 42 |
      | fleamarket_zipCode | 50000 |
      | fleamarket_city | Köln |
      | fleamarket_url | http://www.example.com |
      | marketDate | 31.01.2019 |
      | marketTimeFrom | 09:30 |
      | marketTimeTo | 18:00 |
    And I press "Neuen Termin speichern - click hier!"
    And I wait for "1" seconds
    Then I should see a ".button-warning" element
    And I should see an ".error" element
    And I should see an ".errormessage" element
    And I should see "Bitte alle Pflichtfelder ausfüllen!"

  @javascript
  Scenario: User is shown errormessage when not all mandatory fields are filled
    Given I am slowly authenticated as user
    And I am on "/flohmarkt-anlegen/?test=1"
    And I fill in "fleamarket_name" with "Rudi Bieller"
    And I press "Neuen Termin speichern - click hier!"
    And I wait for "1" seconds
    Then I should see a ".button-warning" element
    And I should see an ".error" element
    And I should see an ".errormessage" element
    And I should see "Bitte alle Pflichtfelder ausfüllen!"

  @javascript
  Scenario: User is shown his own fleamarkets in his list
    Given I have a default organizer
    And I am slowly authenticated as user
    And I go to "/flohmarkt-anlegen/?test=1"
    Then I should see "Veröffentliche hier deine Flohmarkt-Termine!"
    When I fill in the following:
      | marketDate | 31.01.2019 |
      | marketTimeFrom | 09:30 |
      | marketTimeTo | 18:00 |
      | fleamarket_name | Mein Testflohmarkt |
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
    And I check "acceptDataProcessing"
    And I press "Neuen Termin speichern - click hier!"
    And I wait for "1" seconds
    Then I should see a ".button-success" element
    And I should see "Danke - Dein Termin wurde erfolgreich angelegt!"
    When I go to "flohmarkt-bearbeiten/1?test=1"
    Then the "value" attribute of the "#fleamarket_name" element should contain "Mein Testflohmarkt"
    And I should see "Eine Beschreibung" in the "#fleamarket_description" element
    And the "value" attribute of the "#fleamarket_location" element should contain "Zu Hause"
    And the "value" attribute of the "#fleamarket_street" element should contain "Hausstr."
    And the "value" attribute of the "#fleamarket_streetNo" element should contain "42"
    And the "value" attribute of the "#fleamarket_zipCode" element should contain "50000"
    And the "value" attribute of the "#fleamarket_city" element should contain "Köln"
    And the "value" attribute of the "#fleamarket_url" element should contain "http://www.example.com"
    When I fill in the following:
      | fleamarket_name | Mein Testflohmarkt UPDATED |
      | fleamarket_description | Eine Beschreibung UPDATED |
      | fleamarket_location | Zu Hause UPDATED |
      | fleamarket_street | Hausstr. UPDATED |
      | fleamarket_streetNo | 42000 |
      | fleamarket_zipCode | 55555 |
      | fleamarket_city | Köln UPDATED |
      | fleamarket_url | http://www.example.com/UPDATED |
    And I check "acceptDataProcessing"
    And I press "Änderungen speichern - click hier!"
    And I wait for "1" seconds
    Then I should see a ".button-success" element
    And I should see "Dein Termin wurde erfolgreich aktualisiert!"
    When I send a "GET" request to "http://localhost/public/api/v1/fleamarkets"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":[{"id":1,"uuid":"a9d60f43-8d4a-5071-8a49-cc5a474d6c1e","organizer":{"id":2,"uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"user":{"type":"User","identifier":"test@onkel-rudi.de","password":"","hasOptIn":""},"name":"Mein Testflohmarkt UPDATED","description":"Eine Beschreibung UPDATED","dates":[{"start":"2019-01-31 09:30:00","end":"2019-01-31 18:00:00"}],"street":"Hausstr. UPDATED","streetNo":"42000","city":"K\u00f6ln UPDATED","zipCode":"55555","location":"Zu Hause UPDATED","url":"http:\/\/www.example.com\/UPDATED"}]}
    """
    Given I am slowly authenticated as user "test2@onkel-rudi.de"
    And I go to "/profil/"
    Then I should not see "Mein Testflohmarkt"
    And I should not see "Mein Testflohmarkt UPDATED"