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
}