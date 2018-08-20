<?php

use yii\db\Migration;

/**
 * Class m180808_095053_add_colums_user_teams
 */
class m180808_095053_add_colums_user_teams extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //$this->addColumn('user_team', 'id', $this->primaryKey());
        $this->addColumn('user_team', 'status', $this->integer(3)->defaultValue(0));
        $this->addColumn('user_team', 'status_tokin', $this->string(250)->Null());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //return $this->dropColumn('user_team', 'id');
        return $this->dropColumn('user_team', 'status');
        return $this->dropColumn('user_team', 'status_tokin');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180808_095053_add_colums_user_teams cannot be reverted.\n";

        return false;
    }
    */
}
