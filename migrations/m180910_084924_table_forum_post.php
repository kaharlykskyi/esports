<?php

use yii\db\Migration;


class m180910_084924_table_forum_post extends Migration
{
  
    public function safeUp()
    {
        $this->createTable('forum_post', [
            'id' => $this->primaryKey(),
            'forum_topic_id' => $this->integer(),
            'user_id' => $this->integer(),
            'text' => $this->text()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex (
                'idx-forum_post_id',
                'forum_post',
                'forum_topic_id'
        );

        $this->addForeignKey(
                'fk-forum_forum_post_id',
                'forum_post',
                'forum_topic_id',
                'forum_topic',
                'id',
                'CASCADE'
        );

     ////////////////////////////////
        
        $this->createIndex (
                'idx-forum_post_user_id',
                'forum_post',
                'user_id'
        );

        $this->addForeignKey(
                'fk-forum_forum_post_user_id',
                'forum_post',
                'user_id',
                'users',
                'id',
                'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('forum_post');
    }
}
