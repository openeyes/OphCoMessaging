<tr>
    <td class="priority">
        <?= $message->urgent ? "!!" : "" ?>
    </td>
    <td>
        <a href="<?= Yii::app()->createURL("/OphCoMessaging/default/view/", array('id' => $message->event_id)); ?>"><?= Helper::convertDate2NHS($message->getMessageDate());?> </a>
    </td>
    <td>
        <?= $message->event->episode->patient->hos_num ?>
    </td>
    <td>
        <?= $message->event->episode->patient->getHSCICName() ?>
    </td>
    <td>
        <?= $message->event->episode->patient->NHSDate('dob') ?>
    </td>
    <td>
        <?= $message->user->getFullNameAndTitle() ?>
    </td>
    <td>
        <?= strlen($message->message_text) > 50 ? Yii::app()->format->Ntext(substr($message->message_text, 0, 50) . '...') : Yii::app()->format->Ntext($message->message_text); ?>
    </td>
    <td>
        <a href="<?= Yii::app()->createURL("/OphCoMessaging/Inbox/delete/", array('id' => $message->id)); ?>">Delete </a>
    </td>
</tr>