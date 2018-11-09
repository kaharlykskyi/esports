<?php

use yii\db\Migration;
use yii\db\Schema;

class m181018_152936_table_results_statistic_users extends Migration
{

    public function safeUp()
    {
         $this->createTable('results_statistic_users', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'team_id' => $this->integer(),
            'game_id'=>$this->integer(),
            'victories' => $this->integer()->defaultValue(0),
            'loss' => $this->integer()->defaultValue(0),
            'rate' => $this->integer()->defaultValue(0),
            'created_at' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT CURRENT_TIMESTAMP",
            'updated_at' => Schema::TYPE_TIMESTAMP . " DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
        ]);

        $this->createIndex (
            'idx-results_statistic_users',
            'results_statistic_users',
            'team_id'
        );

        $this->addForeignKey(
            'fk-results_statistic_users',
            'results_statistic_users',
            'team_id',
            'teams',
            'id',
            'CASCADE'
        );
////////////////////////////////////////////////////
        $this->createIndex (
            'idx-results_statistic_users_id',
            'results_statistic_users',
            'user_id'
        );

        $this->addForeignKey(
            'fk-results_statistic_users_id',
            'results_statistic_users',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
////////////////////////////////////////////////////////
        $this->createIndex (
            'idx-results_statistic_user_game_id',
            'results_statistic_users',
            'game_id'
        );

        $this->addForeignKey(
            'fk-results_statistic_user_game_id',
            'results_statistic_users',
            'game_id',
            'games',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('results_statistic_users');
    }

}
