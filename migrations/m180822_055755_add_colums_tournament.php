<?php

use yii\db\Migration;

/**
 * Class m180822_055755_add_colums_tournament
 */
class m180822_055755_add_colums_tournament extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tournaments', 'data', $this->text()->Null());
        $this->addColumn('tournaments', 'match_schedule', $this->integer(4)->Null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('tournaments', 'data');
       $this->dropColumn('tournaments', 'match_schedule');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180822_055755_add_colums_tournament cannot be reverted.\n";

        return false;
    }
    */
}
