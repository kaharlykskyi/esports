<?php

use yii\db\Migration;


class m190221_170400_table_sponsor_team extends Migration
{
    
    public function safeUp()
    {
        $this->createTable('sponsor_team', [
            'id' => $this->primaryKey()->unsigned(),
            'team_id' => $this->integer(),
            'name' => $this->string(250)->notNull(),
            'site_url' => $this->string(250)->notNull(),
            'logo' => $this->string(250)->notNull(),
        ]);

        $this->createIndex(
            'idx-team_id-sponsor_team',
            'sponsor_team',
            'team_id'
        );

        $this->addForeignKey(
            'fk-sponsor_team-team_id',
            'sponsor_team',
            'team_id',
            'teams',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('sponsor_team');
    }

 
}
