

<div class="panel">
    <div class="panel-header">Unread Messages</div>
    <div class="panel-body">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'htmlOptions' => array(
        'class' => 'grid',
    ),
    'dataProvider'=>$dp,
    'columns' => array(
        array(
            'name' => 'priority',
            'value' => '$data->urgent'
        ),
		array(
            'class' => 'CLinkColumn',
            'header' => 'Date',
            'labelExpression' => 'Helper::convertMySQL2NHS($data->event->event_date)',
            'urlExpression' => 'Yii::app()->createURL("/OphCoMessaging/default/view/", array("id" => $data->event_id))'
        ),
        'event.episode.patient.hos_num',
        array(
            'name' => 'Name',
            'value' => '$data->event->episode->patient->getHSCICName()'
        ),
        'event.episode.patient.dob',
        array(
            'name' => 'From',
            'value' => '$data->event->user->getFullNameAndTitle()'
        ),
        'message_text',
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{mark}',
            'buttons' => array(
                'mark' => array(
                    'url' => 'Yii::app()->createURL("/OphCoMessaging/Inbox/delete/", array("id" => $data->id))',
                    'label' => 'Mark as Read',
                )
            )
        )
    )
));
?>
    </div>
</div>