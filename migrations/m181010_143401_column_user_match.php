<?php

use yii\db\Migration;

/**
 * Class m181010_143401_column_user_match
 */
class m181010_143401_column_user_match extends Migration
{
    public function safeUp()
    {
        $this->addColumn('users_match', 'state',$this->integer()->null());
    }

    public function safeDown()
    {
        $this->dropColumn('users_match', 'state');
    }


}
