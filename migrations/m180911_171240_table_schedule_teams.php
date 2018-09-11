<?php

use yii\db\Migration;

/**
 * Class m180911_171240_table_schedule_teams
 */
class m180911_171240_table_schedule_teams extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('schedule_teams', [
            'id' => $this->primaryKey(),
            'tournament_id' => $this->integer(),
            'team1' => $this->integer(),
            'team2' => $this->integer(),
            'results1'=> $this->integer()->null(),
            'results2'=> $this->integer()->null(),
            'tur' => $this->integer()->null(),
            'group' => $this->integer()->null(),
            'date' => $this->dateTime()->null(),
        ]);


        $this->createIndex(
            'idx-schedule_teams1_id',
            'schedule_teams',
            'team1'
        );

        $this->addForeignKey(
            'fk-schedule_teams1',
            'schedule_teams',
            'team1',
            'teams',
            'id',
            'CASCADE'
        );

        ////////////////////////////////////////////

        $this->createIndex (
            'idx-schedule_teams2_id',
            'schedule_teams',
            'team2'
        );

        $this->addForeignKey (
            'fk-schedule_teams2',
            'schedule_teams',
            'team2',
            'teams',
            'id',
            'CASCADE'
        );

        /////////////////////////////////
        $this->createIndex(
            'idx-schedule_teams_tournament_id',
            'schedule_teams',
            'tournament_id'
        );

        
        $this->addForeignKey(
            'fk-schedule_teams_tournament_id',
            'schedule_teams',
            'tournament_id',
            'tournaments',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('schedule_teams');
    }

   
}
