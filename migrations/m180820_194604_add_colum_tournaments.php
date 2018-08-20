<?php

use yii\db\Migration;

/**
 * Class m180820_194604_add_colum_tournaments
 */
class m180820_194604_add_colum_tournaments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tournaments', 'flag', $this->integer(3)->Null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tournaments', 'flag');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180820_194604_add_colum_tournaments cannot be reverted.\n";

        return false;
    }
    */
}
