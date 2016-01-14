<?php

class m160113_111638_mark_comment_read extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophcomessaging_message_comment', 'marked_as_read', 'boolean DEFAULT false NOT NULL');
		$this->addColumn('ophcomessaging_message_comment_version', 'marked_as_read', 'boolean DEFAULT false NOT NULL');
	}

	public function down()
	{
		$this->dropColumn('ophcomessaging_message_comment', 'marked_as_read');
		$this->dropColumn('ophcomessaging_message_comment_version', 'marked_as_read');
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