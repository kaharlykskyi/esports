<?php

use yii\db\Migration;

/**
 * Class m180905_160634_add_colums_tournaments
 */
class m180905_160634_add_colums_tournaments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tournaments', 'league_table', $this->text()->Null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tournaments', 'league_table');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180905_160634_add_colums_tournaments cannot be reverted.\n";

        return false;
    }
    */
}
