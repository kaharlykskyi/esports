<?php

use yii\db\Migration;


class m180821_113143_create_table_tournamet_data extends Migration
{

    public function safeUp()
    {
        $this->createTable('tournament_data', [
            'id' => $this->primaryKey(),
            'tournament_id' => $this->integer(),
            'name' => $this->string(200),
            'value' => $this->string(700)->Null(),
        ]);

        $this->createIndex (
            'idx-tournament-data_id',
            'tournament_data',
            'tournament_id'
        );

        $this->addForeignKey(
            'fk-tournament-data_id',
            'tournament_data',
            'tournament_id',
            'tournaments',
            'id',
            'CASCADE'
        );


    }

    public function safeDown()
    {
       $this->dropTable('tournamet_data');
    }

}
