<?php

use yii\db\Migration;
use yii\db\Schema;
/**
 * Class m180803_085541_create_table_games
 */
class m180803_085539_create_table_games extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('games', [
            'id' => $this->primaryKey(),
            'name' => $this->string(200)->notNull()->unique(),
            'alias' => $this->string(50)->unique(),
            'logo' => $this->string(200)->notNull(),
            'filed'=> $this->text()->Null(),
        ]);

        $this->insert('games', [
            'name' => 'HearthStone',
            'logo' =>'hart5-0.png',
            'alias' => 'hearthstone',
            'filed' =>'[{"name":"system","class":"system_select","title":"Game mode","type":"select","options":["Bo1","Bo3","Bo5"]},
                {"name":"validate","title":"Require a Capture at the end of each game to validate the result?","type":"checkbox","options":["1"]},
                {"name":"game_mode","title":"Game mode select","class":"game_mode","type":"select","options":[" Conquist","Last hero standing"]}]',
        ]);
        $this->insert('games', [
            'name' => 'Pokémon',
            'logo' =>'pokemon.png',
            'alias' => 'pokemon',
            'filed' =>'[{"name":"system","title":"Game mode","type":"select","options":["Bo1","Bo3","Bo5"]},{"name":"format","title":"Format","type":"select","options":["VGC19","OU","Ubers","Monotype","Doubles OU","Doubles Ubers"]},{"name":"console","title":"Game console","type":"select","options":["Nintendo 3DS","Pokémon Showdown"]}]',
        ]);
        $this->insert('games', [
            'name' => 'World of Warcraft',
            'logo' =>'wow.png',
            'alias' => 'wow',
            'filed' => '[{"name":"system","title":"System","class":"sistem_wow","type":"select","options":["Bo1","Bo3","Bo5"]},{"name":"format","title":"Format","class":"select_format","type":"select","options":["PvP","PvE"]},
                {"name":"terrain","title":"Terrain","class":"terrain","type":"select","options":["Arena","Battleground"]},
            {"name":"pvp","title":"PvP","class":"hidden_select2","type":"select","options":["10vs10", "15vs15", "40vs40"]},{"name":"pvp","title":"PvP","class":"hidden_select1","type":"select","options":["1vs1", "2vs2", "3vs3", "5vs5"]}]',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('games');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180803_085541_teams cannot be reverted.\n";

        return false;
    }
    */
}
