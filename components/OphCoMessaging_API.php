<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 11/11/15
 * Time: 10:03
 */

namespace OEModule\OphCoMessaging\components;


class OphCoMessaging_API extends \BaseAPI
{
    public function getMenuItems($position = 1)
    {
        
        return array(
            array(
            'uri' => '/OphCoMessaging/default/inbox',
            'title' => 'Messages',
            'position' => $position
        ));
    }
}