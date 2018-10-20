<?php

use yii\db\Migration;


class m181001_091200_column_teams_single_user extends Migration
{
    
    public function safeUp()
    {
        $this->addColumn('teams', 'single_user',$this->integer(3)->Null());
    }


    public function safeDown()
    {
        $this->dropColumn('teams', 'single_user');
    }

}
