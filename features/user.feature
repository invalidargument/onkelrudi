@user
Feature: User login/register page of onkelrudi
  In order to login or register as a new user
  As an onkelrudi user
  I need to be able to create new User and login as an existing one

  @browser
  Scenario Outline: User gets error messages when doing things wrong
    Given I am on "/login/?test=1"
    When I fill in "register_email" with "hans@example.com"
    And I fill in "register_password" with "<password1>"
    And I fill in "register_password_repeat" with "<password2>"
    And I press "Benutzer registrieren - click hier!"
    And I wait for "1" seconds
    Then I should see a "<expectedCssClass>" element
    And I should not see an "<unexpectedCssClass>" element
    And I should see "<expectedMessage>"

    Examples:
      | password1 | password2  | expectedCssClass | unexpectedCssClass | expectedMessage |
      | foobarbaz | foobarbaz  | .button-success  | .errormessage      | Danke - Dein Benutzer wurde erfolgreich angelegt! Bitte schaue in Dein E-Mail-Postfach und folge dem Bestätigungslink, um Deine Registrierung abzuschließen. |
      | foo       | foo        | .button-error    | .successmessage    | Es ist ein Fehler aufgetreten. Passwords must have at least a length of 8 chracters. |
      | foobarbaz | foobarbazz | .button-error    | .successmessage    | Es ist ein Fehler aufgetreten. Passwords do not match. |
