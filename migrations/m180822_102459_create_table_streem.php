<?php

use yii\db\Migration;

/**
 * Class m180822_102459_create_table_streem
 */
class m180822_102459_create_table_streem extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('streem', [
            'id' => $this->primaryKey(),
            'tournament_id' => $this->integer(4),
            'streem_chanal' => $this->integer(4),
            'streem_url' => $this->string(200)->Null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('streem');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180822_102459_create_table_streem cannot be reverted.\n";

        return false;
    }
    */
}
