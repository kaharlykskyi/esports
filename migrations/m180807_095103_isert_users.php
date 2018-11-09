<?php

use yii\db\Migration;


class m180807_095103_isert_users extends Migration
{

    public function safeUp()
    {
        $this->insert('users', [
            'name' => 'Vasa',
            'username' => 'vasa',
            'email' => 'vasan@vasa.com',
            'password' => Yii::$app->security->generatePasswordHash('vasa'),
            'role' => 0,
            'country' => 'United States',
            'visible' =>1,
        ]);

        $this->insert('users', [
            'name' => 'peta',
            'username' => 'peta',
            'email' => 'peta@peta.com',
            'password' => Yii::$app->security->generatePasswordHash('peta'),
            'role' => 0,
            'country' => 'United States',
            'visible' =>1,
        ]);

        $this->insert('users', [
            'name' => 'feda',
            'username' => 'feda',
            'email' => 'feda@feda.com',
            'password' => Yii::$app->security->generatePasswordHash('feda'),
            'role' => 0,
            'country' => 'United States',
            'visible' =>1,
        ]);

    }

    public function safeDown()
    {
       return;
    }


}
