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
        $criteria->params = array(':uid' => $user->id);
        $criteria->order = 'created_date asc';

        $message_count = Element_OphCoMessaging_Message::model()->count($criteria);

		return array(
            'title' => 'Messages',
			'uri' => '/OphCoMessaging/Inbox',
			'messageCount' => $message_count
		);
	}
}