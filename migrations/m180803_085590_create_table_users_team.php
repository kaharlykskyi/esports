<?php

use yii\db\Migration;

/**
 * Class m180803_085541_create_table_games
 */
class m180803_085590_create_table_users_team extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_team', [
            'id_user' => $this->integer(),
            'id_team' => $this->integer(),
        ]);

        // creates index for column `id_user`
        $this->createIndex(
            'idx-id_user',
            'user_team',
            'id_user'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-id_user',
            'user_team',
            'id_user',
            'users',
            'id',
            'CASCADE'
        );

        // creates index for column `id_team`
        $this->createIndex(
            'idx-id_team',
            'user_team',
            'id_team'
        );

        // add foreign key for table `teams`
        $this->addForeignKey(
            'fk-id_team',
            'user_team',
            'id_team',
            'teams',
            'id',
            'CASCADE'
        );
        
        $this->insert('user_team', [
            'id_user' => 1,
            'id_team' => 1,
        ]);

        $this->insert('user_team', [
            'id_user' => 1,
            'id_team' => 2,
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_team');
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
