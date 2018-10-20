<?php

use yii\db\Migration;


class m180911_171250_table_schedule_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('schedule_post', [
            'id' => $this->primaryKey(),
            'schedule_teams_id' => $this->integer(),
            'user_id' => $this->integer(),
            'text' => $this->text()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex (
                'idx-schedule_post_id',
                'schedule_post',
                'schedule_teams_id'
        );

        $this->addForeignKey(
                'fk-forum_schedule_post_id',
                'schedule_post',
                'schedule_teams_id',
                'schedule_teams',
                'id',
                'CASCADE'
        );

     ////////////////////////////////
        
        $this->createIndex (
                'idx-schedule_post_user_id',
                'schedule_post',
                'user_id'
        );

        $this->addForeignKey(
                'fk-forum_schedule_post_user_id',
                'schedule_post',
                'user_id',
                'users',
                'id',
                'CASCADE'
        );
    }


    public function safeDown()
    {
        $this->dropTable('schedule_post');
    }

   
}
