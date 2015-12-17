<?php

use \SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use \Behat\Behat\Exception\BehaviorException;

class OphCoMessagingContext extends PageObjectContext
{
    /**
     * @Given /^I select Create Message$/
     */
    public function iSelectCreateOperationNote() {

        $message = $this->getPage ( 'OphCoMessaging' );
        $message->createMessage();
    }

    /**
     * @Then /^the application returns a validation error containing \'([^\']*)\'$/
     */
    public function applicationReturnsAnError($message)
    {
        /**
         * @var OphCoMessaging
         */
        $page = $this->getPage('OphCoMessaging');
        if (!$page->isValidationMessagePresent($message)) {
            throw new \Behat\Behat\Exception\BehaviorException("Validation error '{$message}' not found");
        };
    }

    /**
     * @Given /^I add a New Event "([^"]*)" for "([^"]*)"$/
     */
    public function iAddANewEventFor($event_name, $subspecialty)
    {
        /**
         * @var OphCoMessaging
         */
        $message = $this->getPage('OphCoMessaging');
        $message->addNewEvent($subspecialty, $event_name);
    }

    /**
     * @Then /^I type "([^"]*)" into the for the attention of field$/
     */
    public function iTypeIntoTheForTheAttentionOfField($arg1)
    {
        $page = $this->getPage('OphCoMessaging');
        $page->typeIntoFAOSearch($arg1);
    }

    /**
     * @Then /^"([^"]*)" is displayed as the selected user$/
     */
    public function isDisplayedAsTheSelectedUser($username)
    {
        $page = $this->getPage('OphCoMessaging');
        $page->selectedUserIs($username);
    }

    /**
     * @Then /^I select "([^"]*)" for the type of message$/
     */
    public function iSelectForTheTypeOfMessage($arg1)
    {
        $page = $this->getPage('OphCoMessaging');
        $page->selectMessageType($arg1);
    }

    /**
     * @Given /^I type "([^"]*)" into the message box$/
     */
    public function iTypeIntoTheMessageBox($arg1)
    {
        $page = $this->getPage('OphCoMessaging');
        $page->enterMessage($arg1);
    }

    /**
     * index is 1-based, not zero based
     *
     * @Given /^I select option "([^"]*)" from the autocomplete list$/
     */
    public function iSelectOptionFromTheAutocompleteList($index)
    {
        $message = $this->getPage("OphCoMessaging");
        $message->selectAutoCompleteOptionByIndex($index-1);
    }

    /**
     * @Then /^I Save the Message and confirm it has been created successfully$/
     */
    public function iSaveTheMessageAndConfirmItHasBeenCreatedSuccessfully()
    {
        /**
         * @var OphCoMessaging
         */
        $message = $this->getPage("OphCoMessaging");
        $message->saveAndConfirm();
    }

    /**
     * @Given /^I confirm that fao user is "([^"]*)"$/
     */
    public function iConfirmThatFaoUserIs($arg1)
    {
        /**
         * @var OphCoMessaging
         */
        $message = $this->getPage("OphCoMessaging");
        $message->checkDisplayFaoIs($arg1);
    }

    /**
     * @Given /^I confirm the message type is "([^"]*)"$/
     */
    public function iConfirmTheMessageTypeIs($arg1)
    {
        /**
         * @var OphCoMessaging
         */
        $message = $this->getPage("OphCoMessaging");
        $message->checkDisplayTypeIs($arg1);
    }

    /**
     * @Given /^I confirm that the message text is "([^"]*)"$/
     */
    public function iConfirmThatTheMessageTextIs($arg1)
    {
        /**
         * @var OphCoMessaging
         */
        $message = $this->getPage("OphCoMessaging");
        $message->checkDisplayMessageIs($arg1);
    }

    /**
     * @Then /^I Edit the displayed event$/
     */
    public function iEditTheDisplayedEvent()
    {
        $message = $this->getPage("OphCoMessaging");
        $message->clickEditLink();
    }

    /**
     * @Given /^I confirm I cannot change the FAO user$/
     */
    public function iConfirmICannotChangeTheFAOUser()
    {
        $message = $this->getPage("OphCoMessaging");
        $message->checkNoUserSearchAvailable();
    }

    /**
     * @Then /^I Save the Message$/
     */
    public function iSaveTheMessage()
    {
        /**
         * @var OphCoMessaging
         */
        $message = $this->getPage("OphCoMessaging");
        $message->saveEvent();
    }


}