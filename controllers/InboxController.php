<?php

namespace OEModule\OphCoMessaging\controllers;

use OEModule\OphCoMessaging\models\Element_OphCoMessaging_Message;

class InboxController extends \BaseModuleController
{
    public $layout='//layouts/main';

    /**
     * Access rules for ticket actions
     *
     * @return array
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index'),
                'roles' => array('OprnLogin'),
            )
        );
    }

    public function actionIndex()
    {
        $user = \Yii::app()->user;
        $criteria = new \CDbCriteria();
        $criteria->addCondition('for_the_attention_of_user_id = :uid');
        $criteria->params = [':uid' => $user->id];
        $criteria->order = 'created_date asc';

        $messages = Element_OphCoMessaging_Message::model()->findAll($criteria);

        $this->render('index', [
            'messages' => $messages,
        ]);
    }
}
