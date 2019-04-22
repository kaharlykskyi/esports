<?php

use yii\db\Migration;
use yii\db\Schema;


class m190411_162019_table_event_user extends Migration
{
 
    public function safeUp()
    {
        $this->createTable('event_user', [
            'id' => $this->primaryKey(),
            'user_id' =>  $this->integer(),
            'type' => $this->tinyInteger()->unsigned()->null(),
            'type_event' => $this->tinyInteger()->unsigned()->null(),
            'event' => $this->tinyInteger()->unsigned()->null(),
            'created_at' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT CURRENT_TIMESTAMP",
            'updated_at' => Schema::TYPE_TIMESTAMP . " DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
        ]);

        /////////////////////////////////
        $this->createIndex(
            'idx-event_user_user_id',
            'event_user',
            'user_id'
        );

        $this->addForeignKey(
            'fk-event_user_user_id',
            'event_user',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('event_user');
    }
}
