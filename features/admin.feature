@admin
Feature: Admin page of onkelrudi
  In order to create new fleamarkets
  As an onkelrudi user
  I need to be able to create new Organizer and Fleamarket

  @javascript
  Scenario: Admin can create a new fleamarket with a new organizer
    Given I have a default organizer
    And I am slowly authenticated as user
    And I go to "/flohmarkt-anlegen/?test=1"
    Then I should see "+ Termin anlegen"
    When I fill in "fleamarket_name" with "Rudi Bieller"
    And I fill in "fleamarket_description" with "Eine Beschreibung"
    And I fill in "fleamarket_location" with "Zu Hause"
    And I fill in "fleamarket_street" with "Hausstr."
    And I fill in "fleamarket_streetNo" with "42"
    And I fill in "fleamarket_zipCode" with "50000"
    And I fill in "fleamarket_city" with "Köln"
    And I fill in "fleamarket_url" with "http://www.example.com"
    And I fill in "organizer_name" with "Die Flohmarkt GmbH"
    And I fill in "organizer_phone" with "0221 1424567890"
    And I fill in "organizer_email" with "example@example.com"
    And I fill in "organizer_url" with "http://www.example.com/foo"
    And I fill in "organizer_street" with "Aachener Straße"
    And I fill in "organizer_streetNo" with "5000"
    And I fill in "organizer_zip" with "5000"
    And I fill in "organizer_city" with "Köln"
    And I fill in "marketDate" with "31.01.2019"
    And I fill in "marketTimeFrom" with "09:30"
    And I fill in "marketTimeTo" with "18:00"
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
    {"data":{"id":"1","uuid":"ca18494a-05ba-57a9-8c1f-d980aeec9a5d","organizer":{"id":"2","uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"user":null,"name":"Rudi Bieller","description":"Eine Beschreibung","dates":[{"start":"2019-01-31 09:30:00","end":"2019-01-31 18:00:00"}],"street":"Hausstr.","streetNo":"42","city":"K\u00f6ln","zipCode":"50000","location":"Zu Hause","url":"http:\/\/www.example.com"}}
    """
    When I send a "GET" request to "http://localhost/public/api/v1/organizers/2"
    Then the response should be
    """
    {"data":{"id":"2","uuid":"1d8a8e24-946c-57b9-be63-a730f281cc17","name":"Die Flohmarkt GmbH","street":"Aachener Stra\u00dfe","streetNo":"5000","zipCode":"5000","city":"K\u00f6ln","phone":"0221 1424567890","email":"example@example.com","url":"http:\/\/www.example.com\/foo"}}
    """

  @javascript
  Scenario: Admin can create a new fleamarket with an existing organizer
    Given I am slowly authenticated as user
    And I have a default organizer
    And I go to "/flohmarkt-anlegen/?test=1"
    Then I should see "+ Termin anlegen"
    When I fill in "fleamarket_name" with "Rudi Bieller"
    And I select "Max Power" from "fleamarket_organizer"
    And I fill in "fleamarket_description" with "Eine Beschreibung"
    And I fill in "fleamarket_location" with "Zu Hause"
    And I fill in "fleamarket_street" with "Hausstr."
    And I fill in "fleamarket_streetNo" with "42"
    And I fill in "fleamarket_zipCode" with "50000"
    And I fill in "fleamarket_city" with "Köln"
    And I fill in "fleamarket_url" with "http://www.example.com"
    And I fill in "marketDate" with "31.01.2019"
    And I fill in "marketTimeFrom" with "09:30"
    And I fill in "marketTimeTo" with "18:00"
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
    {"data":{"id":"1","uuid":"868f3976-d99c-5147-81e7-6113e2af50f9","organizer":{"id":"1","uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"user":null,"name":"Rudi Bieller","description":"Eine Beschreibung","dates":[{"start":"2019-01-31 09:30:00","end":"2019-01-31 18:00:00"}],"street":"Hausstr.","streetNo":"42","city":"K\u00f6ln","zipCode":"50000","location":"Zu Hause","url":"http:\/\/www.example.com"}}
    """

  @javascript
  Scenario: Admin can not create a new fleamarket when no existing organizer is selected and no new organizer provided
    Given I am slowly authenticated as user
    And I am on "/flohmarkt-anlegen/?test=1"
    Then I should see "+ Termin anlegen"
    When I fill in "fleamarket_name" with "Rudi Bieller"
    And I fill in "fleamarket_description" with "Eine Beschreibung"
    And I fill in "fleamarket_location" with "Zu Hause"
    And I fill in "fleamarket_street" with "Hausstr."
    And I fill in "fleamarket_streetNo" with "42"
    And I fill in "fleamarket_zipCode" with "50000"
    And I fill in "fleamarket_city" with "Köln"
    And I fill in "fleamarket_url" with "http://www.example.com"
    And I fill in "marketDate" with "31.01.2019"
    And I fill in "marketTimeFrom" with "09:30"
    And I fill in "marketTimeTo" with "18:00"
    And I press "Neuen Termin speichern - click hier!"
    And I wait for "1" seconds
    Then I should see a ".button-warning" element
    And I should see an ".error" element
    And I should see an ".errormessage" element
    And I should see "Bitte alle Pflichtfelder ausfüllen!"

  @javascript
  Scenario: Admin is shown errormessage when not all mandatory fields are filled
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
  Scenario: Admin can edit only his own fleamarkets
    Given I am slowly authenticated as user
    And I go to "/flohmarkt-anlegen/?test=1"
    Then I should see "+ Termin anlegen"
    When I fill in "fleamarket_name" with "Mein Testflohmarkt"
    And I fill in "fleamarket_description" with "Eine Beschreibung"
    And I fill in "fleamarket_location" with "Zu Hause"
    And I fill in "fleamarket_street" with "Hausstr."
    And I fill in "fleamarket_streetNo" with "42"
    And I fill in "fleamarket_zipCode" with "50000"
    And I fill in "fleamarket_city" with "Köln"
    And I fill in "fleamarket_url" with "http://www.example.com"
    And I fill in "organizer_name" with "Die Flohmarkt GmbH"
    And I fill in "organizer_phone" with "0221 1424567890"
    And I fill in "organizer_email" with "example@example.com"
    And I fill in "organizer_url" with "http://www.example.com/foo"
    And I fill in "organizer_street" with "Aachener Straße"
    And I fill in "organizer_streetNo" with "5000"
    And I fill in "organizer_zip" with "5000"
    And I fill in "organizer_city" with "Köln"
    And I fill in "marketDate" with "31.01.2019"
    And I fill in "marketTimeFrom" with "09:30"
    And I fill in "marketTimeTo" with "18:00"
    And I press "Neuen Termin speichern - click hier!"
    And I wait for "1" seconds
    Then I should see a ".button-success" element
    And I should see "Danke - Dein Termin wurde erfolgreich angelegt!"
    When I go to "flohmarkt-bearbeiten/1"
    And I wait for "1" seconds
    Then the "value" attribute of the "#fleamarket_name" element should contain "Mein Testflohmarkt"
    And I should see "Eine Beschreibung" in the "#fleamarket_description" element
    And the "value" attribute of the "#fleamarket_location" element should contain "Zu Hause"
    And the "value" attribute of the "#fleamarket_street" element should contain "Hausstr."
    And the "value" attribute of the "#fleamarket_streetNo" element should contain "42"
    And the "value" attribute of the "#fleamarket_zipCode" element should contain "50000"
    And the "value" attribute of the "#fleamarket_city" element should contain "Köln"
    And the "value" attribute of the "#fleamarket_url" element should contain "http://www.example.com"
    When I fill in "fleamarket_name" with "Mein Testflohmarkt UPDATED"
    And I fill in "fleamarket_description" with "Eine Beschreibung UPDATED"
    And I fill in "fleamarket_location" with "Zu Hause UPDATED"
    And I fill in "fleamarket_street" with "Hausstr. UPDATED"
    And I fill in "fleamarket_streetNo" with "42000"
    And I fill in "fleamarket_zipCode" with "55555"
    And I fill in "fleamarket_city" with "Köln UPDATED"
    And I fill in "fleamarket_url" with "http://www.example.com/UPDATED"
    And I press "Änderungen speichern - click hier!"
    And I wait for "1" seconds
    Then I should see a ".button-success" element
    And I should see "Dein Termin wurde erfolgreich aktualisiert!"
    When I send a "GET" request to "http://localhost/public/api/v1/fleamarkets/1"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":{"id":"1","uuid":"4d0f6fcd-16e8-56c7-8f25-1e802b50fb95","organizer":{"id":"1","uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"user":null,"name":"Mein Testflohmarkt UPDATED","description":"Eine Beschreibung UPDATED","dates":[{"start":"2019-01-31 09:30:00","end":"2019-01-31 18:00:00"}],"street":"Hausstr. UPDATED","streetNo":"42000","city":"K\u00f6ln UPDATED","zipCode":"55555","location":"Zu Hause UPDATED","url":"http:\/\/www.example.com\/UPDATED"}}
    """
    Given I am slowly authenticated as user "test2@onkel-rudi.de"
    And I go to "/profil/"
    Then I should not see "Mein Testflohmarkt"
    And I should not see "Mein Testflohmarkt UPDATED"