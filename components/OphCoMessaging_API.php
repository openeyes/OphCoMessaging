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

	public function getMenuItem() {

		$user = \Yii::app()->user;
		$elem = new Element_OphCoMessaging_Message();
		$elem->for_the_attention_of_user_id = $user->id;
		$messages = $elem->search();
		// $messages = $elem->searchForUserMessages($user->id);

		return array(
            'title' => 'Messages',
			'uri' => '/OphCoMessaging/Inbox',
			'messageCount' => $messages->getItemCount()
		);
	}
}