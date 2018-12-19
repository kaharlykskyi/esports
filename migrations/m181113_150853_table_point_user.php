<?php

use yii\db\Migration;
use yii\db\Schema;

class m181113_150853_table_point_user extends Migration
{
    
    public function safeUp()
    {
        $this->createTable('user_point', [
            'id' => $this->primaryKey(),
            'user_id' =>  $this->integer()->defaultValue(0),
            'bonus_id' => $this->integer(),
            'appraisal' =>  $this->integer()->defaultValue(0),
            'created_at' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT CURRENT_TIMESTAMP",
            'updated_at' => Schema::TYPE_TIMESTAMP . " DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
        ]);

        /////////////////////////////////
        $this->createIndex(
            'idx-user_point_user_id',
            'user_point',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_point_user_id',
            'user_point',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('user_point');
    }
}
