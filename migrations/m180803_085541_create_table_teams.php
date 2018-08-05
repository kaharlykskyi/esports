<?php

use yii\db\Migration;

/**
 * Class m180803_085541_teams
 */
class m180803_085541_create_table_teams extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('teams', [
            'id' => $this->primaryKey(),
            'name' => $this->string(200)->notNull()->unique(),
            'logo' => $this->string(200)->notNull(),
            'bacgraund' => $this->string(200)->notNull(),
            'game_id' => $this->integer(),
            'website' => $this->string(200)->Null(),
            'captain' => $this->string(200)->notNull()
        ]);


        // creates index for column `game_id`
        $this->createIndex(
            'idx-game_id',
            'teams',
            'game_id'
        );

        // add foreign key for table `games`
        $this->addForeignKey(
            'fk-game_id',
            'teams',
            'game_id',
            'games',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('teams');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180803_085541_teams cannot be reverted.\n";

        return false;
    }
    */
}
