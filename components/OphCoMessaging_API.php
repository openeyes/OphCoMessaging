<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 11/11/15
 * Time: 10:03
 */

namespace OEModule\OphCoMessaging\components;

use OEModule\OphCoMessaging\models\Element_OphCoMessaging_Message;

class OphCoMessaging_API extends \BaseAPI
{

	public function getMenuItem()
    {
        $user = \Yii::app()->user;
        $criteria = new \CDbCriteria();
        $criteria->addCondition('for_the_attention_of_user_id = :uid');
        $criteria->addCondition('marked_as_read = :read');
        $criteria->params = array(':uid' => $user->id, ':read' => false);
        $criteria->order = 'created_date asc';

        $messages = Element_OphCoMessaging_Message::model()->findAll($criteria);
        $containsUrgentMessage = false;
        foreach ($messages as $message) {
            if ($message['urgent']) {
                $containsUrgentMessage = true;
            }
        }

		return array(
            'title' => 'Messages',
			'uri' => '/OphCoMessaging/Inbox',
			'messageCount' => count($messages),
            'containsUrgentMessage' => $containsUrgentMessage
		);
	}

    /**
     * Dashboard index for displaying messages as an embedded view
     *
     * @param null $user
     */
    public function renderDashboard($user = null)
    {
        $read_check = false;

        if (@$_GET['OphCoMessaging_read'] == 1)
            $read_check = true;

        if (is_null($user)) {
            $user = \Yii::app()->user;
        }

        $sort = new \CSort();

        $sort->attributes = array(
            'priority' => array('asc' => 'urgent asc',
                                'desc' => 'urgent desc'),
            'event_date' => array('asc' => 'event.created_date asc',
                                'desc' => 'event.created_date desc'),
            'patient_name' => array('asc' => 'lower(contact.last_name) asc, lower(contact.first_name) asc',
                                    'desc' => 'lower(contact.last_name) desc, lower(contact.first_name) desc'),
            'hos_num' => array('asc' => 'patient.hos_num asc',
                                'desc' => 'patient.hos_num desc'),
            'dob' => array('asc' => 'patient.dob asc',
                            'desc' => 'patient.dob desc'),
            'user' => array('asc' => 'lower(for_the_attention_of_user.last_name) asc, lower(for_the_attention_of_user.first_name) asc',
                            'desc' => 'lower(for_the_attention_of_user.last_name) desc, lower(for_the_attention_of_user.first_name) desc')
        );

        $sort->defaultOrder = array('event_date' => \CSort::SORT_DESC);

        $dp = new \CActiveDataProvider('OEModule\OphCoMessaging\models\Element_OphCoMessaging_Message',
            array(
                'sort' => $sort,
                'criteria' => array(
                    'together' => true,
                    'with' => array('event', 'for_the_attention_of_user', 'message_type', 'event.episode', 'event.episode.patient', 'event.episode.patient.contact'),
                    'condition' => 'for_the_attention_of_user_id = :uid AND marked_as_read = :read',
                    'params' => array(':uid' => $user->id, ':read' => $read_check),
                ),
                'pagination' => array(
                    'pageSize' => 10
                )
            ));
        $criteria = new \CDbCriteria();
        $criteria->addCondition('for_the_attention_of_user_id = :uid');
        $criteria->addCondition('marked_as_read = :read');
        $criteria->params = array(':uid' => $user->id, ':read' => $read_check);
        $criteria->order = 'created_date asc';

        $messages = Element_OphCoMessaging_Message::model()->findAll($criteria);

        \Yii::app()->getAssetManager()->registerCssFile('module.css', 'application.modules.OphCoMessaging.assets.css');

        return array(
            'title' => 'Unread Messages',
            'content' => \Yii::app()->controller->renderPartial('OphCoMessaging.views.inbox.grid', array(
                            'messages' => $messages,
                            'dp' => $dp,
                            'read_check' => $read_check
                        ),true)
        );
    }
}