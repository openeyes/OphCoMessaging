<?php

class m151115_100538_add_message_read_status extends CDbMigration
{
	public function up()
	{
    $this->addColumn('et_ophcomessaging_message', 'marked_as_read', "tinyint(1) unsigned NOT NULL DEFAULT '0'");
    $this->addColumn('et_ophcomessaging_message_version', 'marked_as_read', "tinyint(1) unsigned NOT NULL DEFAULT '0'");
	}

	public function down()
	{
    $this->dropColumn('et_ophcomessaging_message', 'marked_as_read');
    $this->dropColumn('et_ophcomessaging_message_version', 'marked_as_read');
	}
}
