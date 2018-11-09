<?php

use yii\db\Migration;


class m180820_192459_create_table_tournament_user extends Migration
{
    
    public function safeUp()
    {
        $this->createTable('tournament_user', [
            'id' => $this->primaryKey(),
            'tournament_id' => $this->integer(),
            'user_id' => $this->integer(),
            'status' => $this->integer(3)->defaultValue(0),
            'tokin' => $this->string(250)->Null()
        ]);

        $this->createIndex(
            'idx-user_tournament_id',
            'tournament_user',
            'tournament_id'
        );

        // add foreign key for table `tournaments`
        $this->addForeignKey(
            'fk-user_tournament_id',
            'tournament_user',
            'tournament_id',
            'tournaments',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-user_user_id',
            'tournament_user',
            'user_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-user_user_id',
            'tournament_user',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );



    }

    public function safeDown()
    {
        $this->dropTable('tournament_user');
    }

}
