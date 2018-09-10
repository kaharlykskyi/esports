<?php

use yii\db\Migration;

/**
 * Class m180910_110851_table_forum_post_schedule
 */
class m180910_110851_table_forum_post_schedule extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('forum_post_schedule', [
            'id' => $this->primaryKey(),
            'forum_topic_schedule_id' => $this->string(250),
            'name' => $this->string(200)->notNull(),
            'status' => $this->integer(3)->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex (
                'idx-forum_post_schedule_id',
                'forum_post_schedule',
                'forum_topic_schedule_id'
        );

        $this->addForeignKey(
                'fk-forum_post_schedule_id',
                'forum_post_schedule',
                'forum_topic_schedule_id',
                'forum_topic_schedule',
                'id',
                'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('forum_post_schedule');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180910_110851_table_forum_post_schedule cannot be reverted.\n";

        return false;
    }
    */
}
