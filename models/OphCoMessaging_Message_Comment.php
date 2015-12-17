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

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('comment_text', 'safe'),
            array('comment_text', 'required'),
            array('id, comment_text', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'element' => array(self::BELONGS_TO, 'OEModule\\OphCoMessaging\\models\\Element_OphCoMessaging_Message', 'element_id'),
            'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
            'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'comment_text' => 'Comment Text',
        );
    }


}