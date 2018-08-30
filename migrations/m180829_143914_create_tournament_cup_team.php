<?php

use yii\db\Migration;

/**
 * Class m180829_143914_create_tournament_cup_team
 */
class m180829_143914_create_tournament_cup_team extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tournament_cup_team', [
            'id' => $this->primaryKey(),
            'tournament_id' => $this->integer(),
            'team_p' => $this->integer(),
            'team_v' => $this->integer(),
            'tur' => $this->integer(),
            'position' => $this->integer(),
            'result_p' => $this->integer(3),
            'result_v' => $this->integer(3),
        ]);

        $this->createIndex (
                'idx-tournament_cup_teams',
                'tournament_cup_team',
                'tournament_id'
        );

        $this->addForeignKey(
                'fk-tournament_cup_teams',
                'tournament_cup_team',
                'tournament_id',
                'tournaments',
                'id',
                'CASCADE'
        );
///////////////////////////////////////////////
        $this->createIndex (
                'idx-tournament_cup_team_p',
                'tournament_cup_team',
                'team_p'
        );

        $this->addForeignKey(
                'fk-tournament_cup_team_p',
                'tournament_cup_team',
                'team_p',
                'teams',
                'id',
                'CASCADE'
        );
///////////////////////////////////////////////
        $this->createIndex (
                'idx-tournament_cup_team_v',
                'tournament_cup_team',
                'team_v'
        );

        $this->addForeignKey(
                'fk-tournament_cup_team_v',
                'tournament_cup_team',
                'team_v',
                'teams',
                'id',
                'CASCADE'
        );



    }

    
    public function safeDown()
    {
        $this->dropTable('tournamet_data');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180829_143914_tournament_cup_team cannot be reverted.\n";

        return false;
    }
    */
}
