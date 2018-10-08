<?php

use yii\db\Migration;


class m181003_082809_users_match extends Migration
{

    public function safeUp()
    {
         $this->createTable('users_match', [
            'id' => $this->primaryKey(),
            'user1' => $this->integer(),
            'user2' => $this->integer(),
            'tournament_id' => $this->integer(),
            'match' => $this->integer(),
            'results1'=> $this->integer()->null(),
            'results2'=> $this->integer()->null(),
            'round' => $this->integer()->null(),
            'state' => $this->integer()->null(),
            'data' => $this->text(),
        ]);

        /////////////////////////////////
        $this->createIndex(
            'idx-users_match_tournament_id',
            'users_match',
            'tournament_id'
        );

        
        $this->addForeignKey(
            'fk-users_match_tournament_id',
            'users_match',
            'tournament_id',
            'tournaments',
            'id',
            'CASCADE'
        );

        /////////////////////////////////
        $this->createIndex(
            'idx-users_match_user1',
            'users_match',
            'user1'
        );

        
        $this->addForeignKey(
            'fk-users_match_user1',
            'users_match',
            'user1',
            'users',
            'id',
            'CASCADE'
        );

        /////////////////////////////////
        $this->createIndex(
            'idx-users_match_user2',
            'users_match',
            'user2'
        );

        $this->addForeignKey(
            'fk-users_match_user2',
            'users_match',
            'user2',
            'users',
            'id',
            'CASCADE'
        );

        /////////////////////////////////
        $this->createIndex(
            'idx-match_match',
            'users_match',
            'match'
        );

        $this->addForeignKey(
            'fk-schedule_teams_match',
            'users_match',
            'match',
            'schedule_teams',
            'id',
            'CASCADE'
        );

    }

    public function safeDown()
    {
       $this->dropTable('users_match');
    }

}
