<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 16/12/15
 * Time: 09:31
 */

namespace OEModule\OphCoMessaging\models;


class OphCoMessaging_Message_Comment extends \BaseActiveRecordVersioned
{
    /**
     * Returns the static model of the specified AR class.
     * @return the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'ophcomessaging_message_comment';
    }
}