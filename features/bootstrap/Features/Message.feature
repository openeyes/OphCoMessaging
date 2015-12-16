@messaging
Feature: Messaging

  Scenario: Create a new message
    Given I am on the OpenEyes "master" homepage
    And I enter login credentials "admin" and "admin"
    And I select Site "1"
    Then I select a firm of "3"

    Then I search for hospital number "1009465 "

    Then I select the Latest Event

    And I add a New Event "Message" for "Glaucoma"

    And I Save the Event

    Then the application returns a validation error containing 'For the attention of cannot be blank.'

    And the application returns a validation error containing 'Type cannot be blank.'

    And the application returns a validation error containing 'Text cannot be blank.'