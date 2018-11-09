<?php

use yii\db\Migration;
use yii\db\Schema;

class m181016_143520_table_results_statistics extends Migration
{

    public function safeUp()
    {
         $this->createTable('results_statistics', [
            'id' => $this->primaryKey(),
            'team_id' => $this->integer(),
            'game_id' => $this->integer(),
            'victories' => $this->integer()->defaultValue(0),
            'loss' => $this->integer()->defaultValue(0),
            'rate' => $this->integer()->defaultValue(0),
            'created_at' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT CURRENT_TIMESTAMP",
            'updated_at' => Schema::TYPE_TIMESTAMP . " DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
        ]);

        $this->createIndex (
            'idx-results_statistics_team',
            'results_statistics',
            'team_id'
        );

        $this->addForeignKey(
            'fk-results_statistics_team',
            'results_statistics',
            'team_id',
            'teams',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-results_statistics_game',
            'results_statistics',
            'game_id'
        );

        $this->addForeignKey(
            'fk-results_statistics_game',
            'results_statistics',
            'game_id',
            'games',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('results_statistics');
    }

}
