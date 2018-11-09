<?php

use yii\db\Migration;


class m180910_074140_table_forum_topic extends Migration
{
   
    public function safeUp()
    {
        $this->createTable('forum_topic', [
            'id' => $this->primaryKey(),
            'tournament_id' => $this->integer(),
            'name' => $this->string(200)->notNull(),
            'num_schedule' => $this->integer()->null(),
            'user_id' => $this->integer(),
            'status' => $this->integer(3)->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex (
                'idx-forum_topic_tor_id',
                'forum_topic',
                'tournament_id'
        );

        $this->addForeignKey(
                'fk-forum_topic_tor_id',
                'forum_topic',
                'tournament_id',
                'tournaments',
                'id',
                'CASCADE'
        );
        /////////////////////////////////
        $this->createIndex (
                'idx-forum_topic_user_id',
                'forum_topic',
                'user_id'
        );

        $this->addForeignKey(
                'fk-forum_forum_topic_user_id',
                'forum_topic',
                'user_id',
                'users',
                'id',
                'CASCADE'
        );
    }

    public function safeDown()
    {
         $this->dropTable('forum_topic');
    }

}
