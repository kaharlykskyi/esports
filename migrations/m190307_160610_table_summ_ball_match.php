<?php

use yii\db\Migration;


class m190307_160610_table_summ_ball_match extends Migration
{

    public function safeUp()
    {
        $this->createTable('ball_match', [
            'id' => $this->primaryKey()->unsigned(),
            'tournament_id' => $this->integer(),
            'team_id' => $this->integer(),
            'played' => $this->integer()->unsigned()->defaultValue(0),
            'lost' => $this->integer()->unsigned()->defaultValue(0),
            'won' => $this->integer()->unsigned()->defaultValue(0),
            'summ_ball' => $this->integer()->unsigned()->defaultValue(0),

        ]);

        $this->createIndex(
            'idx-ball_match-tournament_id',
            'ball_match',
            'tournament_id'
        );

        $this->addForeignKey(
            'fk-ball_match-tournament_id',
            'ball_match',
            'tournament_id',
            'tournaments',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-ball_match-team_id',
            'ball_match',
            'team_id'
        );

        $this->addForeignKey(
            'fk-ball_match-team_id',
            'ball_match',
            'team_id',
            'teams',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('ball_match');
    }
}
