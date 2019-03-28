<?php

use yii\db\Migration;

/**
 * Class m190320_170657_colum_tabe_games
 */
class m190320_170657_colum_tabe_games extends Migration
{

    public function safeUp()
    {
        $this->addColumn('games', 'status', $this->tinyInteger()->unsigned()->defaultValue(0));
        $this->update('games', array(
              'status' => 1), 
              'id=1'
        );
        $this->update('games', array(
              'status' => 1), 
              'id=2'
        );
        $this->update('games', array(
              'status' => 1), 
              'id=3'
        );
    }

    public function safeDown()
    {
        $this->dropColumn('games', 'status');
    }
}
