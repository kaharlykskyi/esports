<?php

use yii\db\Migration;

/**
 * Class m180823_133008_add_column_tornament_team_user
 */
class m180823_133008_add_column_tornament_team_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->addColumn('tournament_team', 'status',$this->integer(3)->defaultValue(0));
         $this->addColumn('tournament_team', 'tokin', $this->string(250)->Null());
         $this->addColumn('tournament_user', 'status',$this->integer(3)->defaultValue(0));
         $this->addColumn('tournament_user', 'tokin', $this->string(250)->Null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tournament_team', 'status');
        $this->dropColumn('tournament_team', 'tokin');
        $this->dropColumn('tournament_user', 'status');
        $this->dropColumn('tournament_user', 'tokin');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180823_133008_add_column_tornament_team_user cannot be reverted.\n";

        return false;
    }
    */
}
