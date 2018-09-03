<?php

use yii\db\Migration;

/**
 * Class m180820_192459_create_table_tournament_user
 */
class m180820_192459_create_table_tournament_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tournament_user', [
            'id' => $this->primaryKey(),
            'tournament_id' => $this->integer(),
            'user_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-user_tournament_id',
            'tournament_user',
            'tournament_id'
        );

        // add foreign key for table `tournaments`
        $this->addForeignKey(
            'fk-user_tournament_id',
            'tournament_user',
            'tournament_id',
            'tournaments',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-user_user_id',
            'tournament_user',
            'user_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-user_user_id',
            'tournament_user',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tournament_user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180820_192459_create_table_tournament_user cannot be reverted.\n";

        return false;
    }
    */
}
