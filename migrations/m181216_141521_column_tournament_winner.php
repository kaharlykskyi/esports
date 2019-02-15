<?php

use yii\db\Migration;


class m181216_141521_column_tournament_winner extends Migration
{

    public function safeUp()
    {
        $this->addColumn('tournaments','winner',$this->integer()->Null());

        $this->createIndex(
            'idx-tournaments-winner',
            'tournaments',
            'winner'
        );

        $this->addForeignKey(
            'fk-tournaments-winner',
            'tournaments',
            'winner',
            'teams',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropColumn('tournaments','winner');
    }


}
