<?php

use yii\db\Migration;
use yii\db\Schema;

class m190228_172845_table_team_history extends Migration
{

    public function safeUp()
    {
        $this->createTable('team_history', [
            'id' => $this->primaryKey()->unsigned(),
            'team_id' => $this->integer(),
            'event' => $this->text()->notNull(),
            'created_at' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT CURRENT_TIMESTAMP",
        ]);

        $this->createIndex(
            'idx-team_id-team_history',
            'team_history',
            'team_id'
        );

        $this->addForeignKey(
            'fk-team_history-team_id',
            'team_history',
            'team_id',
            'teams',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('team_history');
    }

}
