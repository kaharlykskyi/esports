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
            'background' => $this->string(200)->notNull(),
            'game_id' => $this->integer(),
            'website' => $this->string(200)->Null(),
            'capitan' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
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
        
         // creates index for column `capitan`
        $this->createIndex(
            'idx-capitan',
            'teams',
            'capitan'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-capitan',
            'teams',
            'capitan',
            'users',
            'id',
            'CASCADE'
        );

    $this->insert('teams', [
            'name' => 'Start',
            'logo' => 'logo',
            'background' => 'background',
            'game_id' => 1,
            'website' => 'qqqqqqqqqqqqq',
            'capitan' => 1,
            'created_at' => 1533553967,
            'updated_at' => 1533553967,
    ]);

    $this->insert('teams', [
            'name' => 'Stop',
            'logo' => 'logo',
            'background' => 'background',
            'game_id' => 2,
            'website' => 'qqqqqqqqqqqqq',
            'capitan' => 1,
            'created_at' => 1533553967,
            'updated_at' => 1533553967,
        ]);
    
        
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
