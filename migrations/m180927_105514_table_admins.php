<?php

use yii\db\Migration;
use yii\db\Schema;
/**
 * Class m180927_105514_table_admins
 */
class m180927_105514_table_admins extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('admins', [
            'id' => Schema::TYPE_PK,
            'login' => Schema::TYPE_STRING . "(255) NOT NULL UNIQUE",
            'username' => Schema::TYPE_STRING . "(255) NOT NULL",
            'password' => Schema::TYPE_STRING . "(255) NOT NULL",
            'created_at' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT CURRENT_TIMESTAMP",
            'updated_at' => Schema::TYPE_TIMESTAMP . " DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
        ]);

        $this->insert('admins', [
            'login' => 'admin',
            'username' => 'Admin',
            'password' => Yii::$app->security->generatePasswordHash('admin'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('admins');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180927_105514_table_admins cannot be reverted.\n";

        return false;
    }
    */
}
