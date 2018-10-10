<?php

use yii\db\Migration;

/**
 * Class m181010_085534_colum_user_logo
 */
class m181010_085534_colum_user_logo extends Migration
{

    public function safeUp()
    {
        $this->addColumn('users', 'logo',$this->string(250)->null());
        $this->addColumn('users', 'background',$this->string(250)->null());
    }

    public function safeDown()
    {
        $this->dropColumn('users', 'logo');
        $this->dropColumn('users', 'background');
    }



}
