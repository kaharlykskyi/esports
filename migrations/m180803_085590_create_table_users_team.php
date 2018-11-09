<?php

use yii\db\Migration;


class m180803_085590_create_table_users_team extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_team', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer(),
            'id_team' => $this->integer(),
            'status' => $this->integer(3)->defaultValue(0),
            'status_tokin' => $this->string(250)->Null(),
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

    }

    public function safeDown()
    {
        $this->dropTable('user_team');
    }

  
}
