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
        if (is_null($user)) {
            $user = \Yii::app()->user;
        }

        $dp = new \CActiveDataProvider('OEModule\OphCoMessaging\models\Element_OphCoMessaging_Message',
            array(
                'criteria' => array(
                    'together' => true,
                    'with' => array('event', 'for_the_attention_of_user', 'message_type'),
                    'condition' => 'for_the_attention_of_user_id = :uid AND marked_as_read = :read',
                    'params' => array(':uid' => $user->id, ':read' => false),
                    'order' => 'event.created_date desc'
                ),
                'pagination' => array(
                    'pageSize' => 2
                )
            ));
        $criteria = new \CDbCriteria();
        $criteria->addCondition('for_the_attention_of_user_id = :uid');
        $criteria->addCondition('marked_as_read = :read');
        $criteria->params = array(':uid' => $user->id, ':read' => false);
        $criteria->order = 'created_date asc';

        $messages = Element_OphCoMessaging_Message::model()->findAll($criteria);

        \Yii::app()->controller->renderPartial('OphCoMessaging.views.inbox.grid', array(
            'messages' => $messages,
            'dp' => $dp
        ));
    }
}