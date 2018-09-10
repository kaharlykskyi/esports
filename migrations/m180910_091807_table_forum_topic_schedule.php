<?php

use yii\db\Migration;

/**
 * Class m180910_091807_table_forum_topic_schedule
 */
class m180910_091807_table_forum_topic_schedule extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('forum_topic_schedule', [
            'id' => $this->string(250)->unique(),
            'tournament_id' => $this->integer(),
            'name' => $this->string(200)->notNull(),
            'status' => $this->integer(3)->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);


        $this->createIndex (
                'idx-orum_topic_schedule_id',
                'forum_topic_schedule',
                'id'
        );

        $this->createIndex (
                'idx-forum_topic_schedule_tor_id',
                'forum_topic_schedule',
                'tournament_id'
        );

        $this->addForeignKey(
                'fk-forum_topic_schedule_tor_id',
                'forum_topic_schedule',
                'tournament_id',
                'tournaments',
                'id',
                'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('forum_topic_schedule');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180910_091807_table_forum_topic_schedule cannot be reverted.\n";

        return false;
    }
    */
}
