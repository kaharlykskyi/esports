<?php

use yii\db\Migration;


class m181028_141514_colum_statistic extends Migration
{

    public function safeUp()
    {
        $this->addColumn('results_statistics', 'rate', $this->integer()->defaultValue(0));
        $this->addColumn('results_statistic_users', 'rate', $this->integer()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropTable('results_statistic');
        $this->dropTable('results_statistic_users');
    }
}
