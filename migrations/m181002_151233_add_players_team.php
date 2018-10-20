<?php

use yii\db\Migration;


class m181002_151233_add_players_team extends Migration
{

    public function safeUp()
    {
        for ($i=1; $i < 11; $i++) { 
            for ($a=1; $a < 9; $a++) {
                $this->insert('users', [
                    'name' => 'User'.$i.$a,
                    'username' => 'user'.$i.$a,
                    'email' => 'user'.$i.$a.'@user.com',
                    'password' => Yii::$app->security->generatePasswordHash('user'),
                    'role' => 0,
                    'country' => 'United States',
                    'visible' =>1,
                ]);
                
            }
        }
    }

    public function safeDown()
    {
        echo "m181002_151233_add_players_team cannot be reverted.\n";

        return false;
    }
}
