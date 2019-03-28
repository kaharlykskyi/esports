<?php

use yii\db\Migration;

/**
 * Class m190326_154439_column_message_user
 */
class m190326_154439_column_message_user extends Migration
{

    public function safeUp()
    {
        $this->addColumn('message_user', 'type', $this->tinyInteger()->unsigned()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('message_user', 'type');
    }

   
}
