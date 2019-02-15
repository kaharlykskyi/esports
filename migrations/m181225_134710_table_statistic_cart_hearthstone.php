<?php

use yii\db\Migration;


class m181225_134710_table_statistic_cart_hearthstone extends Migration
{

    public function safeUp()
    {
        $this->createTable('statistic_cards_hearthstone', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer(),
            'cart_id' => $this->integer(),
        ]);

        $this->createIndex (
            'idx-hearthstone-cart_id',
            'statistic_cards_hearthstone',
            'cart_id'
        );

        $this->createIndex (
            'idx-cards_hearthstone',
            'statistic_cards_hearthstone',
            'user_id'
        );

        $this->addForeignKey (
            'fk-cards_hearthstone',
            'statistic_cards_hearthstone',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
       $this->dropTable('statistic_cards_hearthstone');
    }

}
