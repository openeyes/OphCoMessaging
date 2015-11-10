<?php

class DefaultController extends BaseEventTypeController
{
    static protected $action_types = array(
        'userfind' => self::ACTION_TYPE_CREATE,
    );

    /**
     * Duplicated from the admin controller to give a user list
     *
     */
    public function actionUserFind()
    {
        $res = array();
        if (Yii::app()->request->isAjaxRequest && !empty($_REQUEST['search'])) {
            $criteria = new CDbCriteria;
            $criteria->compare("LOWER(username)", strtolower($_REQUEST['search']),true, 'OR');
            $criteria->compare("LOWER(first_name)",strtolower($_REQUEST['search']),true, 'OR');
            $criteria->compare("LOWER(last_name)",strtolower($_REQUEST['search']),true, 'OR');
            $words = explode(" ", $_REQUEST['search']);
            if (count($words) > 1) {
                // possibly slightly verbose approach to checking first and last name combinations
                // for searches
                $first_criteria = new CDbCriteria();
                $first_criteria->compare("LOWER(first_name)", strtolower($words[0]),true);
                $first_criteria->compare("LOWER(last_name)", strtolower(implode(" ", array_slice($words,1,count($words)-1))),true);
                $last_criteria = new CDbCriteria();
                $last_criteria->compare("LOWER(first_name)", strtolower($words[count($words)-1]),true);
                $last_criteria->compare("LOWER(last_name)", strtolower(implode(" ", array_slice($words,0,count($words)-2))),true);
                $first_criteria->mergeWith($last_criteria, 'OR');
                $criteria->mergeWith($first_criteria, 'OR');
            }

            foreach (User::model()->findAll($criteria) as $user) {
                $res[] = array(
                    'id' => $user->id,
                    'label' => $user->getFullNameAndTitle(),
                    'value' => $user->getFullName(),
                    'username' => $user->username,
                );
            }
        }
        echo CJSON::encode($res);
    }
}
