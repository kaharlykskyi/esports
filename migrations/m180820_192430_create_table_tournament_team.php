<?php

use yii\db\Migration;

/**
 * Class m180820_192430_create_table_tournament_team
 */
class m180820_192430_create_table_tournament_team extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tournament_team', [
            'id' => $this->primaryKey(),
            'tournament_id' => $this->integer(),
            'team_id' => $this->integer(),
            'status' => $this->integer(3)->defaultValue(0),
            'tokin' => $this->string(250)->Null()
        ]);


        $this->createIndex(
            'idx-tournament_id',
            'tournament_team',
            'tournament_id'
        );

        // add foreign key for table `tournaments`
        $this->addForeignKey(
            'fk-tournament_id',
            'tournament_team',
            'tournament_id',
            'tournaments',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-team_id',
            'tournament_team',
            'team_id'
        );

        // add foreign key for table `teams`
        $this->addForeignKey(
            'fk-team_id',
            'tournament_team',
            'team_id',
            'teams',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('tournament_team');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180820_192430_create_table_tournament_team cannot be reverted.\n";

        return false;
    }
    */
}
