<?php
return array(
    'params' => array(
        'dashboard_items' => array(

            array(
                'module' => 'OphCoMessaging',
                // default action is the 'renderDashboard' if 'actions' array is  not set
                'actions' => array(
                    'getInboxMessages',
                    'getSentMessages',
                 )
            ),
            array(
                'title' => "Demo Dashboard Widget",
                'content' => "<i>This is a placeholder widget to allow users to try out the drag and drop functionality</i>"
            )

        )
    )
);