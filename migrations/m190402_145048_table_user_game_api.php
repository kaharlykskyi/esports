<?php

use yii\db\Migration;

/**
 * Class m190402_145048_table_user_game_api
 */
class m190402_145048_table_user_game_api extends Migration
{

    public function safeUp()
    {
        $this->createTable('user_game_api', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->notNull(),
            'platform' => $this->tinyInteger()->unsigned()->notNull(),
            'region' => $this->tinyInteger()->unsigned()->notNull(),
            'battletag' => $this->string(200)->notNull(),
            'rating' => $this->integer()->unsigned()->defaultValue(0),
            'data' => $this->text()->null(),
        ]);
           
        $this->createIndex(
            'idx-user_game_api-user',
            'user_game_api',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_game_api-user',
            'user_game_api',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropTable('user_game_api');
    }


}
