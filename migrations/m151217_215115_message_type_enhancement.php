<?php

class m151217_215115_message_type_enhancement extends OEMigration
{
	public function up()
	{
        $this->addColumn('ophcomessaging_message_message_type', 'reply_required', 'boolean DEFAULT false NOT NULL');
        $this->addColumn('ophcomessaging_message_message_type_version', 'reply_required', 'boolean DEFAULT false NOT NULL');

        $this->insert('ophcomessaging_message_message_type',array('name'=>'Query','reply_required' => true, 'display_order'=>2));
	}

	public function down()
	{
        $this->delete('ophcomessaging_message_message_type_version', 'reply_required = true');
		$this->dropColumn('ophcomessaging_message_message_type_version', 'reply_required');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}