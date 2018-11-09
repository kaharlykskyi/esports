<?php

use yii\db\Migration;
use yii\db\Schema;

class m180927_134405_table_news extends Migration
{

    public function safeUp()
    {
         $this->createTable('news', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'title' => $this->string(200)->notNull(),
            'description' => $this->text(),
            'logo' => $this->string(250)->null(),
            'state' => $this->integer(3)->defaultValue(1),
            'created_at' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT CURRENT_TIMESTAMP",
            'updated_at' => Schema::TYPE_TIMESTAMP . " DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
        ]);

        $this->createIndex(
            'idx-news_category_id',
            'news',
            'category_id'
        );

        $this->addForeignKey(
            'fk-news_category_id',
            'news',
            'category_id',
            'news_category',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('news');
    }

}
