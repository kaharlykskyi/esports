<?php

use yii\db\Migration;

/**
 * Class m180817_074620_create_table_tournaments
 */
class m180817_074620_create_table_tournaments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tournaments', [
            'id' => $this->primaryKey(),
            'name' => $this->string(200)->notNull()->unique(),
            'game_id' => $this->integer(),
            'user_id' => $this->integer(),
            'format' => $this->integer(3)->notNull(),
            'rules' => $this->text()->notNull(),
            'prizes' => $this->text()->notNull(),
            'flag' =>  $this->integer(3)->Null(),
            'region' => $this->string(200),
            'time_limit' => $this->integer()->Null(),
            'start_date' => $this->dateTime()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex (
                'idx-game_id',
                'tournaments',
                'game_id'
        );

        $this->addForeignKey(
                'fk-games_id',
                'tournaments',
                'game_id',
                'games',
                'id',
                'CASCADE'
        );


         $this->createIndex (
                'idx-user_id',
                'tournaments',
                'user_id'
        );

        $this->addForeignKey(
                'fk-users_id',
                'tournaments',
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
        $this->dropTable('tournaments');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180817_074620_create_table_tournaments cannot be reverted.\n";

        return false;
    }
    */
}
