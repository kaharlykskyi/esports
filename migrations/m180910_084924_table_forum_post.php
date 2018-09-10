<?php

use yii\db\Migration;

/**
 * Class m180910_084924_table_forum_post
 */
class m180910_084924_table_forum_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('forum_post', [
            'id' => $this->primaryKey(),
            'forum_topic_id' => $this->integer(),
            'name' => $this->string(200)->notNull(),
            'status' => $this->integer(3)->defaultValue(0),
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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('forum_post');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180910_084924_table_forum_post cannot be reverted.\n";

        return false;
    }
    */
}
