<?php

use yii\db\Migration;

/**
 * Class m180813_150734_add_colum_user
 */
class m180813_150734_add_colum_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'sex', $this->integer(3)->Null());
        $this->addColumn('users', 'birthday', $this->date()->Null());
        $this->addColumn('users', 'favorite_game', $this->integer(3)->Null());
        $this->addColumn('users', 'activities', $this->text()->Null());
        $this->addColumn('users', 'interests', $this->text()->Null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return $this->dropColumn('users', 'sex');
        return $this->dropColumn('users', 'birthday');
        return $this->dropColumn('users', 'favorite_game');
        return $this->dropColumn('users', 'activities');
        return $this->dropColumn('users', 'interests');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180813_150734_add_colum_user cannot be reverted.\n";

        return false;
    }
    */
}
