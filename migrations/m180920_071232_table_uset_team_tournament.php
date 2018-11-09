<?php

use yii\db\Migration;

/**
 * Class m180920_071232_table_uset_team_tournament
 */
class m180920_071232_table_uset_team_tournament extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('uset_team_tournament', [
            'id' => $this->primaryKey(),
            'tournament_id' => $this->integer(),
            'team_id' => $this->integer(),
            'user_id' => $this->integer(),
            'text' => $this->text()->null(),
            'fair_play' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex (
                'idx-uset_team_tournament_id',
                'uset_team_tournament',
                'tournament_id'
        );

        $this->addForeignKey(
                'fk-uset_team_tournament_id',
                'uset_team_tournament',
                'tournament_id',
                'tournaments',
                'id',
                'CASCADE'
        );
        /////////////////////////////////////
        $this->createIndex (
                'idx-uset_team_tournament_team_id',
                'uset_team_tournament',
                'team_id'
        );

        $this->addForeignKey(
                'fk-uset_team_tournament_team_id',
                'uset_team_tournament',
                'team_id',
                'teams',
                'id',
                'CASCADE'
        );
        /////////////////////////////////////
        $this->createIndex (
                'idx-uset_team_tournament_user_id',
                'uset_team_tournament',
                'user_id'
        );

        $this->addForeignKey(
                'fk-uset_team_tournament_user_id',
                'uset_team_tournament',
                'user_id',
                'users',
                'id',
                'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('uset_team_tournament');
    }

    
}
