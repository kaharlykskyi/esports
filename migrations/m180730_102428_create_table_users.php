<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180730_102428_create_table_users
 */
class m180730_102428_create_table_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . "(255) NOT NULL",
            'username' => Schema::TYPE_STRING . "(255) NOT NULL UNIQUE",
            'email' => Schema::TYPE_STRING . "(255) NOT NULL UNIQUE",
            'password' => Schema::TYPE_STRING . "(255) NOT NULL",
            'role' => Schema::TYPE_INTEGER . "(1) DEFAULT '0'",
            'country' => Schema::TYPE_STRING . "(255) NOT NULL",
            'restore_token' => Schema::TYPE_STRING . "(255)",
            'created_at' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT CURRENT_TIMESTAMP",
            'updated_at' => Schema::TYPE_TIMESTAMP . " DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
        ]);

        $this->insert('users', [
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Yii::$app->security->generatePasswordHash('admin'),
            'role' => 0,
            'country' => 'United States',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
