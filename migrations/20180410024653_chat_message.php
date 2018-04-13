<?php

use Phpmig\Migration\Migration;

class ChatMessage extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $this->getContainer()['db']->exec("
            CREATE TABLE `chat_message` (
              `id` binary(16) NOT NULL,
              `fromId` bigint(16) NOT NULL,
              `message` text,
              `created_at` int(11) DEFAULT NULL,
              `updated_at` int(11) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->getContainer()['db']->exec("
            DROP DATABASE `chat_message`
        ");
    }
}
