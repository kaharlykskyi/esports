<?php

use yii\db\Migration;

/**
 * Class m180829_143914_create_tournament_cup_team
 */
class m180829_143914_add_tournaments_colums extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tournaments', 'cup', $this->text()->Null());
        $this->addColumn('tournaments', 'league', $this->text()->Null());
    }

    
    public function safeDown()
    {
        $this->dropColumn('tournaments', 'cup');
        $this->dropColumn('tournaments', 'league');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180829_143914_tournament_cup_team cannot be reverted.\n";

        return false;
    }
    */
}
