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
}