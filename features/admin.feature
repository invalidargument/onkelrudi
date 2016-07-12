@admin
Feature: Admin page of onkelrudi
  In order to create new fleamarkets
  As an onkelrudi user
  I need to be able to create new Organizer and Fleamarket

  @browser
  Scenario: Admin can create a new fleamarket with a new organizer
    Given I have a default organizer
    And I am slowly authenticated as user
    And I go to "/flohmarkt-anlegen/?test=1"
    Then I should see "+ Termin anlegen"
    When I fill in "fleamarket_name" with "Rudi Bieller"
    And I fill in "fleamarket_description" with "Eine Beschreibung"
    And I fill in "fleamarket_location" with "Meine alte Wohnung"
    And I fill in "fleamarket_street" with "Richmodstr."
    And I fill in "fleamarket_streetNo" with "23"
    And I fill in "fleamarket_zipCode" with "50667"
    And I fill in "fleamarket_city" with "Köln"
    And I fill in "fleamarket_url" with "http://www.example.com"
    And I fill in "organizer_name" with "Die Flohmarkt GmbH"
    And I fill in "organizer_phone" with "0221 1234567890"
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
    {"data":{"id":"1","uuid":"bbbbcfc1-83e2-5391-ac98-bbea6210501b","organizer":{"id":"2","uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"user":null,"name":"Rudi Bieller","description":"Eine Beschreibung","dates":[{"start":"2019-01-31 09:30:00","end":"2019-01-31 18:00:00"}],"street":"Richmodstr.","streetNo":"23","city":"K\u00f6ln","zipCode":"50667","location":"Meine alte Wohnung","url":"http:\/\/www.example.com"}}
    """
    When I send a "GET" request to "http://localhost/public/api/v1/organizers/2"
    Then the response should be
    """
    {"data":{"id":"2","uuid":"ccd3d17a-3b2e-5991-9840-9bc0c5c2d9e2","name":"Die Flohmarkt GmbH","street":"Aachener Stra\u00dfe","streetNo":"5000","zipCode":"5000","city":"K\u00f6ln","phone":"0221 1234567890","email":"example@example.com","url":"http:\/\/www.example.com\/foo"}}
    """

  @browser
  Scenario: Admin can create a new fleamarket with an existing organizer
    Given I have a default organizer
    And I am slowly authenticated as user
    And I go to "/flohmarkt-anlegen/?test=1"
    Then I should see "+ Termin anlegen"
    When I fill in "fleamarket_name" with "Rudi Bieller"
    And I select "Max Power" from "fleamarket_organizer"
    And I fill in "fleamarket_description" with "Eine Beschreibung"
    And I fill in "fleamarket_location" with "Meine alte Wohnung"
    And I fill in "fleamarket_street" with "Richmodstr."
    And I fill in "fleamarket_streetNo" with "23"
    And I fill in "fleamarket_zipCode" with "50667"
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
    {"data":{"id":"1","uuid":"02129607-aa9f-5466-a416-cec4881afd58","organizer":{"id":"1","uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"user":null,"name":"Rudi Bieller","description":"Eine Beschreibung","dates":[{"start":"2019-01-31 09:30:00","end":"2019-01-31 18:00:00"}],"street":"Richmodstr.","streetNo":"23","city":"K\u00f6ln","zipCode":"50667","location":"Meine alte Wohnung","url":"http:\/\/www.example.com"}}
    """

  @browser
  Scenario: Admin can not create a new fleamarket when no existing organizer is selected and no new organizer provided
    #Given I have no default organizer
    Given I am on "/flohmarkt-anlegen/?test=1"
    And I am authenticated as user
    Then I should see "+ Termin anlegen"
    When I fill in "fleamarket_name" with "Rudi Bieller"
    And I fill in "fleamarket_description" with "Eine Beschreibung"
    And I fill in "fleamarket_location" with "Meine alte Wohnung"
    And I fill in "fleamarket_street" with "Richmodstr."
    And I fill in "fleamarket_streetNo" with "23"
    And I fill in "fleamarket_zipCode" with "50667"
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

  @browser
  Scenario: Admin is shown errormessage when not all mandatory fields are filled
    Given I am on "/flohmarkt-anlegen/?test=1"
    And I am authenticated as user
    And I fill in "fleamarket_name" with "Rudi Bieller"
    And I press "Neuen Termin speichern - click hier!"
    And I wait for "1" seconds
    Then I should see a ".button-warning" element
    And I should see an ".error" element
    And I should see an ".errormessage" element
    And I should see "Bitte alle Pflichtfelder ausfüllen!"