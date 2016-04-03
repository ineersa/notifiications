<?php

use yii\db\Migration;

class m160403_114618_browser_query extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%browser_query}}', [
            'id' => $this->primaryKey(),
            'notification_id' => $this->integer()->notNull(),
            'notification_title' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%browser_query_read}}', [
            'id' => $this->primaryKey(),
            'notification_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addForeignKey('idx-browser_query-notification_id','{{%browser_query}}','notification_id','{{%notifications}}','id','CASCADE');
        $this->addForeignKey('idx-browser_query_read-notification_id','{{%browser_query_read}}','notification_id','{{%notifications}}','id','CASCADE');
        $this->addForeignKey('idx-browser_query_read-user_id','{{%browser_query_read}}','user_id','{{%user}}','id','CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%browser_query}}');
        $this->dropTable('{{%browser_query_read}}');
    }

}
