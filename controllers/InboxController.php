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
                'actions' => array('index', 'markread', 'markunread'),
                'roles' => array('OprnLogin'),
            )
        );
    }

    public function actionIndex()
    {
        $user = \Yii::app()->user;
        $criteria = new \CDbCriteria();
        $criteria->addCondition('for_the_attention_of_user_id = :uid');
        $criteria->addCondition('marked_as_read = :read');
        $criteria->params = array(':uid' => $user->id, ':read' => false);
        $criteria->order = 'created_date asc';

        $messages = Element_OphCoMessaging_Message::model()->findAll($criteria);

        $this->render('index', array(
            'messages' => $messages,
        ));
    }

    public function actionMarkRead($id)
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('id = :id');
        $criteria->params = array(':id' => $id);

        $message = Element_OphCoMessaging_Message::model()->find($criteria);
        $message->updateByPk($id, array('marked_as_read' => 1));
        $this->redirect(array('/OphCoMessaging/Inbox'));
    }

}
