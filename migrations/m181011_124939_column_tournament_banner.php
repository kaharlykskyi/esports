<?php

use yii\db\Migration;


class m181011_124939_column_tournament_banner extends Migration
{

    public function safeUp()
    {
        $this->addColumn('tournaments', 'prize_pool',$this->integer()->null());
        $this->addColumn('tournaments', 'banner',$this->string(250)->null());
    }


    public function safeDown()
    {
        $this->dropColumn('tournaments', 'banner');
        $this->dropColumn('tournaments', 'prize_pool');
    }
}
