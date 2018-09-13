<?php

use yii\db\Migration;

/**
 * Class m180910_111515_column_tournament_forum_text
 */
class m180910_111515_column_tournament_forum_text extends Migration
{
   
    public function safeUp()
    {
        // $this->addColumn('tournaments', 'forum_text', $this->text()->Null());
        
        // $this->update('games', 
        //     ['filed' => '[{"name":"system","class":"system_select","title":"Game mode","type":"select","options":["Bo1","Bo3","Bo5"]},{"name":"validate","title":"Require a Capture at the end of each game to validate the result?","type":"checkbox","options":["1"]},{"name":"game_mode","title":"Game mode select","type":"select","options":[" Conquist","Last hero standing"]}]'], 
        //     ['id' => 1]
        // );
        // $this->update('games', 
        //     ['filed' => '[{"name":"system","title":"Game mode","type":"select","options":["Bo1","Bo3","Bo5"]},{"name":"format","title":"Format","type":"select","options":["VGC19","OU","Ubers","Monotype","Doubles OU","Doubles Ubers"]},{"name":"console","title":"Game console","type":"select","options":["Nintendo 3DS","Pokémon Showdown"]}]'], 
        //     ['id' => 2]
        // );
        // $this->update('games', 
        //     ['filed' => '[{"name":"*","title":"Format","class":"select_format","type":"select","options":["PvP","PvE"]},{"name":"pvp","title":"PvP","class":"nidden_select","type":"select","options":["2vs2","3vs3"]},{"name":"mythical","class":"hidden_num","title":"Mythical","type":"number","options":""},{"name":"system","title":"System","type":"select","options":["Bo1","Bo3","Bo5"]}]'], 
        //     ['id' => 3]
        // );
        $this->addColumn('tournaments', 'state', $this->integer(3)->null());
    }

        
    public function safeDown()
    {
        $this->dropColumn('tournaments', 'forum_text');
        $this->dropColumn('tournaments', 'state');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180910_111515_column_tournament_forum_text cannot be reverted.\n";

        return false;
    }
    */
}
