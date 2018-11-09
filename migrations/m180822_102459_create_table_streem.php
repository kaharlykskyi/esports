<?php

use yii\db\Migration;

class m180822_102459_create_table_streem extends Migration
{

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

    public function safeDown()
    {
        $this->dropTable('streem');
    }
}
