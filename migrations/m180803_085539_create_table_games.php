<?php

use yii\db\Migration;

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
            'logo' => $this->string(200)->notNull(),
            'filed'=> $this->text()->Null(),
        ]);

        $this->insert('games', [
            'name' => 'HearthStone',
            'logo' =>'hart5-0.png',
            'filed' =>'[{"name":"system","class":"system_select","title":"select","type":"select","options":["Bo1","Bo3","Bo5"]},{"name":"validate","title":"Require a Capture at the end of each game to validate the result?","type":"checkbox","options":["1"]},{"name":"game_mode","title":"Game mode select","type":"select","options":[" Conquist","Last","Hero","Standing"]}]',
        ]);
        $this->insert('games', [
            'name' => 'Pokémon',
            'logo' =>'pokemon.png',
            'filed' =>'[{"name":"system","title":"select","type":"select","options":["Bo1","Bo3","Bo5"]},{"name":"format","title":"Format","type":"select","options":["VGC19","OU","Ubers","Monotype","Doubles OU","Doubles Ubers"]},{"name":"console","title":"Game console","type":"select","options":["Nintendo 3DS","Pokémon Showdown"]}]',
        ]);
        $this->insert('games', [
            'name' => 'World of Warcraft',
            'logo' =>'wow.png',
            'filed' => '[{"name":"*","title":"Format","class":"select_format","type":"select","options":["PvP","PvE"]},{"name":"pvp","title":"PvP","class":"nidden_select","type":"select","options":["2vs2","3vs3"]},{"name":"mythical","class":"hidden_num","title":"Mythical","type":"number","options":""},{"name":"system","title":"System","type":"select","options":["Bo1","Bo3","Bo5"]}]',
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
