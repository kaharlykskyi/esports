<?php

use yii\db\Migration;

/**
 * Class m190227_145602_user_column_ban_date
 */
class m190227_145602_user_column_ban_date extends Migration
{

    public function safeUp()
    {
        $this->addColumn('users', 'ban_date', $this->date()->null());
    }

    public function safeDown()
    {
        $this->dropColumn('users', 'ban_date');
    }
}
