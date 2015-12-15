Messaging
=========

Event messaging module to allow notes to be made on patient records. Provides a dashboard view of messages that have been created for a user.

Configuration
=============

Add the module to the application configuration:

    'OphCoMessaging' => array('class' => '\OEModule\OphCoMessaging\OphCoMessagingModule')


In the module config is the details for the dashboard integration


    'params' => array(
        'dashboard_items' => array(
            array(
                'api' => 'OphCoMessaging'
            )
        )
    )
