<?php

use yii\db\Migration;

/**
 * Class m180910_074140_table_forum_topic
 */
class m180910_074140_table_forum_topic extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('forum_topic', [
            'id' => $this->primaryKey(),
            'tournament_id' => $this->integer(),
            'name' => $this->string(200)->notNull(),
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

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->dropTable('forum_topic');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180910_074140_table_forum_topic cannot be reverted.\n";

        return false;
    }
    */
}
