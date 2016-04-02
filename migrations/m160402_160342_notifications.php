<?php

use yii\db\Migration;

class m160402_160342_notifications extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%notifications}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'event' => $this->string()->notNull(),
            'from' => $this->integer()->notNull(),
            'to' => $this->integer()->notNull(),
            'notification_title' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'type' => $this->string()->notNull()
        ], $tableOptions);

        $this->addForeignKey('idx-notifications-from','{{%notifications}}','from','{{%user}}','id','CASCADE');
//        $this->addForeignKey('idx-notifications-to','{{%notifications}}','to','{{%user}}','id','CASCADE');
        $this->createIndex('idx-notifications-event', '{{%notifications}}', 'event');
    }

    public function down()
    {
        $this->dropTable('{{%notifications}}');
    }
}
