<?php

use yii\db\Migration;
use yii\db\Schema;

class m181012_154133_table_news_category extends Migration
{
    public function safeUp()
    {
         $this->createTable('news_category', [
            'id' => $this->primaryKey(),
            'title' => $this->string(200)->notNull(),
            'created_at' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT CURRENT_TIMESTAMP",
            'updated_at' => Schema::TYPE_TIMESTAMP . " DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('news_category');
    }
}
