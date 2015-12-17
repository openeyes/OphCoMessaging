<?php

class m151215_105050_add_message_comment extends OEMigration
{
	public function up()
	{
        $this->createOETable('ophcomessaging_message_comment', array(
            'id' => 'pk',
            'comment_text' => 'text DEFAULT \'\' NOT NULL',
            'element_id' => 'int(10) unsigned NOT NULL',
            'KEY `ophcomessaging_message_comment_element_id_fk` (`element_id`)',
            'CONSTRAINT `ophcomessaging_message_comment_element_id_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophcomessaging_message` (`id`)'
        ), true);
	}

	public function down()
	{
		$this->dropOETable('ophcomessaging_message_comment', true);
	}

}