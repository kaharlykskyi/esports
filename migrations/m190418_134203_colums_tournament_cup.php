<?php

use yii\db\Migration;

/**
 * Class m190418_134203_colums_tournament_cup
 */
class m190418_134203_colums_tournament_cup extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('tournaments', 'partisipation_data');
        $this->dropColumn('tournaments', 'league_table');
        $this->addColumn('tournaments', 'rank', $this->tinyInteger()->unsigned()->defaultValue(0));
        $this->addColumn('tournaments', 'private', $this->tinyInteger()->unsigned()->defaultValue(0));
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->dropColumn('tournaments', 'league_table');
        
    }


}
