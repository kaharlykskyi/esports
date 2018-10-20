<?php

use yii\db\Migration;


class m181018_140537_colums_game extends Migration
{

    public function safeUp()
    {
        $this->addColumn('games', 'alias',$this->string(50)->unique());
        $this->addColumn('results_statistics', 'game_id',$this->integer());

        $this->createIndex(
            'idx-results_statistics_game',
            'results_statistics',
            'game_id'
        );

        $this->addForeignKey(
            'fk-results_statistics_game',
            'results_statistics',
            'game_id',
            'games',
            'id',
            'CASCADE'
        );

        $this->update('games', ['alias' => 'hearthstone'], ['id' => 1]);
        $this->update('games', ['alias' => 'pokemon'], ['id' => 2]);
        $this->update('games', ['alias' => 'wow'], ['id' => 3]);
    }

    public function safeDown()
    {
        $this->dropColumn('games', 'alias');
        $this->dropColumn('results_statistics','game_id');
    }

}
