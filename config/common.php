<?php
return array(
    'params' => array(
        'dashboard_items' => array(
            array(
                'module' => 'OphCoMessaging',
                // default action is the 'renderDashboard' if 'actions' array is  not set
                'actions' => array(
                    'getInboxMessages',
                    'getSentMessages'
                 )
            )
        )
    )
);