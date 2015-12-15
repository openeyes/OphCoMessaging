<?php

namespace OEModule\OphCoMessaging\controllers;

class DefaultController extends \BaseEventTypeController
{
    const ACTION_TYPE_MYMESSAGE = "ManageMyMessage";

    static protected $action_types = array(
        'userfind' => self::ACTION_TYPE_CREATE,
        'markread' => self::ACTION_TYPE_MYMESSAGE,
        'markunread' => self::ACTION_TYPE_MYMESSAGE,
    );

    /**
     * @var \OEModule\OphCoMessaging\models\Element_OphCoMessaging_Message
     */
    protected $message_el;

    /**
     * Make sure user has clinical access and the user is the recipient of the message
     *
     * @return bool
     */
    public function checkManageMyMessageAccess()
    {
        return $this->checkAccess('OprnViewClinical') && $this->isIntendedRecipient();
    }

    /**
     * Convenience wrapper to retrieve event view URL (this should probably be somewhere in core)
     *
     * @return mixed
     */
    public function getEventViewUrl()
    {
        return \Yii::app()->createUrl('/' . $this->getModule()->name . '/Default/view/' . $this->event->id);
    }

    /**
     * Duplicated from the admin controller to give a user list
     * @TODO: There's a method on the UserController that could be used, so would be worth consolidating)
     */
    public function actionUserFind()
    {
        $res = array();
        if (\Yii::app()->request->isAjaxRequest && !empty($_REQUEST['search'])) {
            $criteria = new \CDbCriteria;
            $criteria->compare("LOWER(username)", strtolower($_REQUEST['search']),true, 'OR');
            $criteria->compare("LOWER(first_name)",strtolower($_REQUEST['search']),true, 'OR');
            $criteria->compare("LOWER(last_name)",strtolower($_REQUEST['search']),true, 'OR');
            $words = explode(" ", $_REQUEST['search']);
            if (count($words) > 1) {
                // possibly slightly verbose approach to checking first and last name combinations
                // for searches
                $first_criteria = new \CDbCriteria();
                $first_criteria->compare("LOWER(first_name)", strtolower($words[0]),true);
                $first_criteria->compare("LOWER(last_name)", strtolower(implode(" ", array_slice($words,1,count($words)-1))),true);
                $last_criteria = new \CDbCriteria();
                $last_criteria->compare("LOWER(first_name)", strtolower($words[count($words)-1]),true);
                $last_criteria->compare("LOWER(last_name)", strtolower(implode(" ", array_slice($words,0,count($words)-2))),true);
                $first_criteria->mergeWith($last_criteria, 'OR');
                $criteria->mergeWith($first_criteria, 'OR');
            }

            foreach (\User::model()->findAll($criteria) as $user) {
                $res[] = array(
                    'id' => $user->id,
                    'label' => $user->getFullNameAndTitle(),
                    'value' => $user->getFullName(),
                    'username' => $user->username,
                );
            }
        }
        echo \CJSON::encode($res);
    }

    /**
     * Set up event etc on the controller
     *
     * @throws \CHttpException
     */
    public function initActionMarkRead()
    {
        $this->initWithEventId(@$_GET['id']);
    }

    /**
     * Mark the event message as read
     *
     * @param $id
     * @throws \CHttpException
     */
    public function actionMarkRead($id)
    {
        $el = $this->getMessageElement();
        $el->marked_as_read = true;
        $el->save();
        $this->event->audit('event', 'marked read');

        \Yii::app()->user->setFlash('success', "<a href=\"" . $this->getEventViewUrl() . "\">{$this->event_type->name}</a> marked as read.");

        $this->redirectAfterAction();
    }

    /**
     * Setup event etc on the controller
     *
     * @throws \CHttpException
     */
    public function initActionMarkUnread()
    {
        $this->initWithEventId(@$_GET['id']);
    }

    /**
     * Mark the message event as unread
     *
     * @param $id
     * @throws \Exception
     */
    public function actionMarkUnread($id)
    {
        $el = $this->getMessageElement();
        $el->marked_as_read = false;
        $el->save();
        $this->event->audit('event', 'marked unread');

        \Yii::app()->user->setFlash('success', "<a href=\"" . $this->getEventViewUrl() . "\">{$this->event_type->name}</a> marked as unread.");

        $this->redirectAfterAction();
    }

    /**
     * Convenience function for performing redirect once a message has been manipulated
     */
    protected function redirectAfterAction()
    {
        if (!$return_url = @$_GET['returnUrl']) {
            if (!$return_url = @$_POST['returnUrl']) {
                $return_url = $this->getEventViewUrl();
            }
        }
        $this->redirect($return_url);
    }

    /**
     * Determine if the given user (or current if none given) is the intended recipient of the message
     * that is being viewed
     *
     * @param \OEWebUser $user
     * @return bool
     */
    protected function isIntendedRecipient(\OEWebUser $user = null)
    {
        if (is_null($user)) {
            $user = \Yii::app()->user;
        }

        if ($el = $this->getMessageElement()) {
            if ($el->for_the_attention_of_user_id == $user->getId()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Convenience wrapper function
     *
     * @return \OEModule\OphCoMessaging\models\Element_OphCoMessaging_Message
     */
    protected function getMessageElement()
    {
        if (!$this->message_el) {
            $this->message_el = $this->event->getElementByClass('\OEModule\OphCoMessaging\models\Element_OphCoMessaging_Message');
        }
        return $this->message_el;
    }

    /**
     *
     * @return bool
     */
    public function canMarkRead()
    {
        $el = $this->getMessageElement();
        if ($this->isIntendedRecipient()
            && !$el->marked_as_read) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function canMarkUnRead()
    {
        $el = $this->getMessageElement();
        if ($this->isIntendedRecipient()
            && $el->marked_as_read) {
            return true;
        }

        return false;
    }
}
