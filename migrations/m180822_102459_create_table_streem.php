<?php

use yii\db\Migration;

/**
 * Class m180822_102459_create_table_streem
 */
class m180822_102459_create_table_streem extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('stream', [
            'id' => $this->primaryKey(),
            'tournament_id' => $this->integer(),
            'stream_chanal' => $this->integer(4),
            'stream_url' => $this->string(200)->Null(),
        ]);



         $this->createIndex(
            'idx-stream_tournament_id',
            'stream',
            'tournament_id'
        );

        // add foreign key for table `tournaments`
        $this->addForeignKey(
            'fk-stream_tournament_id',
            'stream',
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
        $this->dropTable('streem');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180822_102459_create_table_streem cannot be reverted.\n";

        return false;
    }
    */
}
