<?php
use yii\db\Migration;

class m181002_102813_colum_shelude_team extends Migration
{
    public function safeUp()
    {
        $this->addColumn('schedule_teams', 'active_result',$this->integer(3)->Null());
    }
    public function safeDown()
    {
        $this->dropColumn('schedule_teams', 'active_result');
    }
}
