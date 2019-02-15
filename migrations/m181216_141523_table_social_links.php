<?php

use yii\db\Migration;

/**
 * Class m181213_175601_table_social_links
 */
class m181216_141523_table_social_links extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('social_links', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'social_id' => $this->integer(),
            'link' => $this->text(),
        ]);

        $this->createIndex (
            'idx-social_id',
            'social_links',
            'user_id'
        );

        $this->addForeignKey(
            'fk-social_id',
            'social_links',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('social_links');
    }


}
