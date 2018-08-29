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
            'team_id' => $this->integer(),
            'tur' => $this->integer(),
            'position' => $this->integer(),
        ]);

        $this->createIndex (
                'idx-tournament_cup_team',
                'tournament_cup_team',
                'tournament_id'
        );

        $this->addForeignKey(
                'fk-tournament_cup_team',
                'tournament_cup_team',
                'tournament_id',
                'tournaments',
                'id',
                'CASCADE'
        );
///////////////////////////////////////////////
        $this->createIndex (
                'idx-tournament_cup_team_id',
                'tournament_cup_team',
                'team_id'
        );

        $this->addForeignKey(
                'fk-tournament_cup_team_id',
                'tournament_cup_team',
                'team_id',
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
