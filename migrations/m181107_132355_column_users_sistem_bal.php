<?php

use yii\db\Migration;

/**
 * Class m181107_132355_column_users_sistem_bal
 */
class m181107_132355_column_users_sistem_bal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users','system_ball',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users','system_ball');
    }


}
