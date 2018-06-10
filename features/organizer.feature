@organizer
Feature: User with role Organizer
  In order to act as role Organizer
  As an onkelrudi organizer-user
  I need to be able to edit my organizer profile and create/edit my fleamarkets

  @javascript
  Scenario: Organizer can go through create/update cycle for profile and fleamarket
    Given I have an Organizer User with Email "info@onkel-rudi.de"
    When I go to "/login/"
    And I fill in "login_email" with "info@onkel-rudi.de"
    And I fill in "login_password" with "aaaaaaaa"
    And I press "Anmelden"
    And I wait for "1" seconds
    Then I should see "Danke - Du hast Dich erfolgreich angemeldet!"
    When I go to "/profil/"
    Then I should see "Du hast noch keinen Flohmarkt angelegt"
    And I should see "Dein Veranstalterprofil"
    And the "value" attribute of the "#organizer_name" element should contain "info@onkel-rudi.de"
    When I fill in the following:
      | organizer_name | Der große Organizer |
      | organizer_phone | 0221 1234567890 |
      | organizer_email | info@onkel-rudi.de |
      | organizer_url | https://www.onkel-rudi.de |
      | organizer_street | Hausstr. |
      | organizer_streetNo | 42 |
      | organizer_zip | 50000 |
      | organizer_city | Köln |
    And I check "acceptDataProcessing"
    And I press "speichern"
    And I wait for "1" seconds
    Then I should see a ".successmessage" element
    When I go to "/profil/"
    And the "value" attribute of the "#organizer_name" element should contain "Der große Organizer"
    And the "value" attribute of the "#organizer_phone" element should contain "0221 1234567890"
    And the "value" attribute of the "#organizer_email" element should contain "info@onkel-rudi.de"
    And the "value" attribute of the "#organizer_url" element should contain "https://www.onkel-rudi.de"
    And the "value" attribute of the "#organizer_street" element should contain "Hausstr."
    And the "value" attribute of the "#organizer_streetNo" element should contain "42"
    And the "value" attribute of the "#organizer_zip" element should contain "50000"
    And the "value" attribute of the "#organizer_city" element should contain "Köln"
    When I go to "/flohmarkt-anlegen/?test=1"
    And I fill in the following:
      | fleamarket_name | Mein Testflohmarkt |
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
    And I check "acceptDataProcessing"
    And I press "Neuen Termin speichern - click hier!"
    And I wait for "1" seconds
    Then I should see a ".button-success" element
    When I send a "GET" request to "http://localhost/public/api/v1/fleamarkets/1"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":{"id":1,"uuid":"4d0f6fcd-16e8-56c7-8f25-1e802b50fb95","organizer":{"id":1,"uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"user":null,"name":"Mein Testflohmarkt","description":"Eine Beschreibung","dates":[{"start":"2019-01-31 09:30:00","end":"2019-01-31 18:00:00"}],"street":"Hausstr.","streetNo":"42","city":"K\u00f6ln","zipCode":"50000","location":"Zu Hause","url":"http:\/\/www.example.com"}}
    """
    When I send a "GET" request to "http://localhost/public/api/v1/organizers/1"
    Then the response should be
    """
    {"data":{"id":1,"uuid":"47f1f5ac-60dc-5105-9f35-5deddc657d92","name":"Der gro\u00dfe Organizer","street":"Hausstr.","streetNo":"42","zipCode":"50000","city":"K\u00f6ln","phone":"0221 1234567890","email":"info@onkel-rudi.de","url":"https:\/\/www.onkel-rudi.de"}}
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
    And I press "Änderungen speichern - click hier!"
    And I wait for "1" seconds
    Then I should see a ".button-success" element
    And I should see "Dein Termin wurde erfolgreich aktualisiert!"
    When I send a "GET" request to "http://localhost/public/api/v1/fleamarkets/1"
    Then the response code should be "200"
    And the response should be json
    And the response should be
    """
    {"data":{"id":1,"uuid":"4d0f6fcd-16e8-56c7-8f25-1e802b50fb95","organizer":{"id":1,"uuid":null,"name":null,"street":null,"streetNo":null,"zipCode":null,"city":null,"phone":null,"email":null,"url":null},"user":null,"name":"Mein Testflohmarkt UPDATED","description":"Eine Beschreibung UPDATED","dates":[{"start":"2019-01-31 09:30:00","end":"2019-01-31 18:00:00"}],"street":"Hausstr. UPDATED","streetNo":"42000","city":"K\u00f6ln UPDATED","zipCode":"55555","location":"Zu Hause UPDATED","url":"http:\/\/www.example.com\/UPDATED"}}
    """