<?php

use yii\db\Migration;

/**
 * Class m180807_095103_add_colum_users
 */
class m180807_095103_add_colum_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'visible', $this->integer(1)->defaultValue(0)); 
        $this->insert('users', [
            'name' => 'Vasa',
            'username' => 'vasa',
            'email' => 'vasan@vasa.com',
            'password' => Yii::$app->security->generatePasswordHash('vasa'),
            'role' => 0,
            'country' => 'United States',
        ]);

        $this->insert('users', [
            'name' => 'peta',
            'username' => 'peta',
            'email' => 'peta@peta.com',
            'password' => Yii::$app->security->generatePasswordHash('peta'),
            'role' => 0,
            'country' => 'United States',
        ]);

        $this->insert('users', [
            'name' => 'feda',
            'username' => 'feda',
            'email' => 'feda@feda.com',
            'password' => Yii::$app->security->generatePasswordHash('feda'),
            'role' => 0,
            'country' => 'United States',
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return $this->dropColumn('users', 'visible');
         
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180807_095103_add_colum_users cannot be reverted.\n";

        return false;
    }
    */
}
