<?php

use yii\db\Migration;
use yii\db\Schema;


class m181012_154527_column_news_category extends Migration
{
    public function safeUp()
    {
        $this->addColumn('news', 'category_id',$this->integer());

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
        $this->addColumn('news', 'logo',$this->string(250)->null());

    }
    public function safeDown()
    {
        $this->dropColumn('news', 'category_id');
    }
}
