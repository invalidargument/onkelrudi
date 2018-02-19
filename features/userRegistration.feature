@user
Feature: User login/register page of onkelrudi
  In order to login or register as a new user
  As an onkelrudi user
  I need to be able to create new User and login as an existing one

  @javascript
  Scenario Outline: User gets proper feedback when trying to create a new user
    Given I am on "/login/"
    When I fill in "register_email" with "info@onkel-rudi.de"
    And I fill in "register_password" with "<password1>"
    And I fill in "register_password_repeat" with "<password2>"
    And I press "Neuen Benutzer anlegen"
    And I wait for "1" seconds
    Then I should see a "<expectedCssClass>" element
    And I should not see an "<unexpectedCssClass>" element
    And I should see "<expectedMessage>"

    Examples:
      | password1 | password2  | expectedCssClass | unexpectedCssClass | expectedMessage |
      | foobarbaz | foobarbaz  | .button-success  | .errormessage      | Danke - Dein Benutzer wurde erfolgreich angelegt! Bitte schaue in Dein E-Mail-Postfach (info@onkel-rudi.de) und folge dem Bestätigungslink, um Deine Registrierung abzuschließen. |
      | foo       | foo        | .button-error    | .successmessage    | Es ist etwas schiefgegangen: Passwords must have a minimum length of 8 chracters. |
      | foobarbaz | foobarbazz | .button-error    | .successmessage    | Es ist etwas schiefgegangen: Passwords do not match. |


  @javascript
  Scenario Outline: User gets proper feedback when trying to create a new organizer user
    Given I am on "/login/"
    When I fill in "register_email" with "info@onkel-rudi.de"
    And I fill in "register_password" with "<password1>"
    And I fill in "register_password_repeat" with "<password2>"
    And I check "register_as_organizer"
    And I press "Neuen Benutzer anlegen"
    And I wait for "1" seconds
    Then I should see a "<expectedCssClass>" element
    And I should not see an "<unexpectedCssClass>" element
    And I should see "<expectedMessage>"

    Examples:
      | password1 | password2  | expectedCssClass | unexpectedCssClass | expectedMessage |
      | foobarbaz | foobarbaz  | .button-success  | .errormessage      | Danke - Dein Benutzer wurde erfolgreich angelegt! Bitte schaue in Dein E-Mail-Postfach (info@onkel-rudi.de) und folge dem Bestätigungslink, um Deine Registrierung abzuschließen. |
      | foo       | foo        | .button-error    | .successmessage    | Es ist etwas schiefgegangen: Passwords must have a minimum length of 8 chracters. |
      | foobarbaz | foobarbazz | .button-error    | .successmessage    | Es ist etwas schiefgegangen: Passwords do not match. |

  Scenario: User can use created opt-in token
    Given I have a user with email "info@onkel-rudi.de" and optin token "test-token"
    And I am on "/opt-in/token-test-token"
    Then I should see "Dein Login wurde aktiviert, Du kannst Dich jetzt anmelden."

  @javascript
  Scenario: User can login after creating and opting in a new user
    Given I am on "/login/"
    When I fill in "register_email" with "info@onkel-rudi.de"
    And I fill in "register_password" with "foobarbaz"
    And I fill in "register_password_repeat" with "foobarbaz"
    And I press "Neuen Benutzer anlegen"
    And I wait for "1" seconds
    And I optin my user "info@onkel-rudi.de"
    And I go to "/login/"
    And I fill in "login_email" with "info@onkel-rudi.de"
    And I fill in "login_password" with "foobarbaz"
    And I press "Anmelden"
    And I wait for "1" seconds
    Then I should see "Danke - Du hast Dich erfolgreich angemeldet!"

  @javascript
  Scenario: User can login after creating and opting in a new organizer
    Given I am on "/login/"
    When I fill in "register_email" with "info@onkel-rudi.de"
    And I fill in "register_password" with "foobarbaz"
    And I fill in "register_password_repeat" with "foobarbaz"
    And I check "register_as_organizer"
    And I press "Neuen Benutzer anlegen"
    And I wait for "1" seconds
    And I optin my user "info@onkel-rudi.de"
    And I go to "/login/"
    And I fill in "login_email" with "info@onkel-rudi.de"
    And I fill in "login_password" with "foobarbaz"
    And I press "Anmelden"
    And I wait for "1" seconds
    Then I should see "Danke - Du hast Dich erfolgreich angemeldet!"
