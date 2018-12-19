<?php

use yii\db\Migration;


class m181212_110124_column_message_user extends Migration
{


    public function safeUp()
    {
        $this->addColumn('message_user','view_status',$this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('message_user','view_status');
    }

}
