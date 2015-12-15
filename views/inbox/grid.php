

<div class="panel">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'itemsCssClass' => 'grid',
    'dataProvider'=>$dp,
    'htmlOptions' => array('id' => 'inbox-table'),
    'summaryText' => '<h3>Unread Messages <small>{start}-{end} of {count}</small></h3>',
    'columns' => array(
        array(
            'name' => 'priority',
            // not ideal using the error class, but a simple solution for now.
            'value' => function($data) {
                return $data->urgent ? "<span class=\"priority fa fa-exclamation\"></span>" : "<span class=\"fa fa-minus\"></span>";
            },
            'type' => 'raw',
            'htmlOptions' => array(
                'class' => 'text-center'
            )
        ),
		array(
            'id' => 'event_date',
            'class' => 'CLinkColumn',
            'header' => $dp->getSort()->link('event_date','Date',array('class'=>'sort-link')),
            'labelExpression' => 'Helper::convertMySQL2NHS($data->event->event_date)',
            'urlExpression' => 'Yii::app()->createURL("/OphCoMessaging/default/view/", array("id" => $data->event_id))',
            'htmlOptions' => array('class' => 'date')
        ),
        array(
            'id' => 'hos_num',
            'header' => $dp->getSort()->link('hos_num', 'Hospital No.', array('class' => 'sort-link')),
            'value' => '$data->event->episode->patient->hos_num'
        ),
        array(
            'id' => 'patient_name',
            'class' => 'CDataColumn',
            'header' => $dp->getSort()->link('patient_name','Name',array('class'=>'sort-link')),
            'value' => '$data->event->episode->patient->getHSCICName()'
        ),
        array(
            'id' => 'dob',
            'class' => 'CDataColumn',
            'header' => $dp->getSort()->link('dob','DOB',array('class'=>'sort-link')),
            'value' => 'Helper::convertMySQL2NHS($data->event->episode->patient->dob)',
            'htmlOptions' => array('class' => 'date')
        ),
        array(
            'id' => 'user',
            'header' => $dp->getSort()->link('user','From',array('class'=>'sort-link')),
            'value' => '$data->event->user->getFullNameAndTitle()'
        ),
        array(
            'name' => 'Message',
            'value' => function($data) {
                return strlen($data->message_text) > 50 ? \Yii::app()->format->Ntext(substr($data->message_text, 0, 50) . ' ...') : \Yii::app()->format->Ntext($data->message_text);
            },
            'type' => 'raw',
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{mark}',
            'buttons' => array(
                'mark' => array(
                    'options' => array('title' => 'Mark as read'),
                    'url' => 'Yii::app()->createURL("/OphCoMessaging/Default/markRead/", array(
                        "id" => $data->event->id,
                        "returnUrl" => \Yii::app()->request->requestUri))',
                    'label' => '<button class="warning small">read</button>',

                )
            )
        )
    )
));
?>
</div>