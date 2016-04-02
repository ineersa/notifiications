<?php

use yii\db\Migration;

class m160402_152437_articles extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%articles}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'sitename' => $this->string()->notNull(),
            'article_name' => $this->string()->notNull(),
            'text' => $this->text()->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%articles}}');
    }

}
