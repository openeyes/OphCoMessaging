<?php

namespace OEModule\OphCoMessaging\controllers;

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
        $this->render('index');
    }
}
