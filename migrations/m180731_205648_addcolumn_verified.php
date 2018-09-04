<?php

use yii\db\Migration;

/**
 * Class m180731_205648_add_users_line
 */
class m180731_205648_addcolumn_verified extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('users', 'tokin_conf', $this->string(250)->Null()); 
       $this->addColumn('users', 'is_verified', $this->integer(1)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'tokin_conf');
        $this->dropColumn('users', 'is_verified');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180731_205648_add_users_line cannot be reverted.\n";

        return false;
    }
    */
}
