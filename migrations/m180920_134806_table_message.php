<?php

use yii\db\Migration;


class m180920_134806_table_message extends Migration
{

    public function safeUp()
    {
         $this->createTable('message_user', [
            'id' => $this->primaryKey(),
            'sender' => $this->integer(),
            'recipient' => $this->integer(),
            'text' => $this->text()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-message_user_sender',
            'message_user',
            'sender'
        );

        $this->addForeignKey(
            'fk-message_user_sender',
            'message_user',
            'sender',
            'users',
            'id',
            'CASCADE'
        );

        ////////////////////////////////////////////

        $this->createIndex (
            'idx-message_user_recipient',
            'message_user',
            'recipient'
        );

        $this->addForeignKey (
            'fk-message_user_recipient',
            'message_user',
            'recipient',
            'users',
            'id',
            'CASCADE'
        );

    }


    public function safeDown()
    {
        $this->dropTable('uset_team_tournament');
    }

   
}
