<?php
use Behat\Behat\Exception\BehaviorException;

class OphCoMessaging extends OpenEyesPage
{
    protected $elements = array(
        'validationErrors' => array(
            'xpath' => "//div[contains(@class, 'alert-box') and contains(@class, 'error')]",
        ),
        'sidebar' => array(
            'xpath' => "//*[@class='episode-title']"
        ),
        'newEventButton' => array(
            'xpath' => "//button[contains(@class, 'addEvent') and contains(@class, 'enabled')]"
        ),
        'newEventDialog' => array(
            'xpath' => "//*[@id='add-new-event-dialog']"
        ),
        'fao_search' => array(
            'xpath' => "//input[@id='find-user']"
        ),
        'selected_user_display' => array(
            'xpath' => "//*[@id='fao_user_display']"
        ),
        'message_type' => array(
            'xpath' => "//*[@id='OEModule_OphCoMessaging_models_Element_OphCoMessaging_Message_message_type_id']"
        ),
        'message_text' => array(
            'xpath' => "//*[@id='OEModule_OphCoMessaging_models_Element_OphCoMessaging_Message_message_text']"
        )
    );

    public function isValidationMessagePresent($message)
    {
        if ($validation = $this->getElement('validationErrors')) {
            return $validation->has('xpath', "//*[contains(text(),'{$message}')]");
        }
    }

    /**
     * more pragramatic approach to expanding sidebar, which should be in core
     *
     * @TODO: put in core
     * @param $subspecialty
     */
    public function expandSubspecialty($subspecialty)
    {
        $el = $this->getElement('sidebar')->find('xpath', "//a[contains(text(),'{$subspecialty}')]");
        if (!$el->hasClass('selected')) {
            $el->click();
        }
    }

    /**
     * Create a new event of the given name
     *
     * @TODO: put in core
     * @param $subspecialty
     * @param string $event_name
     * @throws BehaviorException
     */
    public function addNewEvent($subspecialty, $event_name = "Message")
    {
        $this->expandSubspecialty($subspecialty);
        $this->getDriver()->wait(5000, 'window.$ && $.active ==0');
        $this->getElement('newEventButton')->click();
        $this->getDriver()->wait(5000, 'window.$ && $.active ==0');
        if ($new_event_link = $this->getElement('newEventDialog')->find('xpath', "//*[contains(text(), '{$event_name}')]")) {
            $new_event_link->click();
        }
        else {
            throw new BehaviorException("new event link for {$event_name} not found.");
        }
    }

    /**
     * Search for a user in the FAO field
     *
     * @param $search_term
     */
    public function typeIntoFAOSearch($search_term)
    {
        $field = $this->getElement('fao_search');
        $field->focus();
        $field->setValue($search_term);
        $field->keyDown(40);

    }

    /**
     * Crude selection of the autocomplete results (searching by text value is awkward because of span
     * highlighting for the match)
     *
     * @TODO: improve autocomplete results so can select by attribute of the term?
     * @param $index
     */
    public function selectAutoCompleteOptionByIndex($index)
    {

        $this->getDriver()->wait(5000, 'window.$ && $.active ==0');
        $auto_results = $this->findAll('xpath', "//ul[contains(@class,'ui-autocomplete')]//li");
        $auto_results[$index]->click();
    }

    /**
     * @param $username
     * @throws BehaviorException
     */
    public function selectedUserIs($username)
    {
        if (!$this->getElement('selected_user_display')->getText() == $username) {
            throw new BehaviorException("selected user is not {$username}, it is " . $this->getElement('selected_user_display')->getText());
        }
    }

    /**
     * @param $type
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function selectMessageType($type)
    {
        $this->getElement('message_type')->selectOption($type);
    }

    public function enterMessage($message)
    {
        $this->getElement('message_text')->setValue($message);
    }
}