<?php

use yii\db\Migration;

/**
 * Class m180910_111515_column_tournament_forum_text
 */
class m180910_111515_update_games extends Migration
{
   
    public function safeUp()
    {
        // $this->update('games', 
        //     ['filed' => '[{"name":"system","class":"system_select","title":"Game mode","type":"select","options":["Bo1","Bo3","Bo5"]},
        //         {"name":"validate","title":"Require a Capture at the end of each game to validate the result?","type":"checkbox","options":["1"]},
        //         {"name":"game_mode","title":"Game mode select","class":"game_mode","type":"select","options":[" Conquist","Last hero standing"]}]'
        //     ], 
        //     ['id' => 1]
        // );
        // $this->update('games', 
        //     ['filed' => '[{"name":"system","title":"Game mode","type":"select","options":["Bo1","Bo3","Bo5"]},{"name":"format","title":"Format","type":"select","options":["VGC19","OU","Ubers","Monotype","Doubles OU","Doubles Ubers"]},{"name":"console","title":"Game console","type":"select","options":["Nintendo 3DS","Pokémon Showdown"]}]'], 
        //     ['id' => 2]
        // );
        // $this->update('games', 
        //     ['filed' => '[{"name":"system","title":"System","class":"sistem_wow","type":"select","options":["Bo1","Bo3","Bo5"]},{"name":"format","title":"Format","class":"select_format","type":"select","options":["PvP","PvE"]},
        //         {"name":"terrain","title":"Terrain","class":"terrain","type":"select","options":["Arena","Battleground"]},
        //         {"name":"pvp","title":"PvP","class":"hidden_select2","type":"select","options":["10vs10", "15vs15", "40vs40"]},{"name":"pvp","title":"PvP","class":"hidden_select1","type":"select","options":["1vs1", "2vs2", "3vs3", "5vs5"]}]'
        //     ], 
        //     ['id' => 3]
        // );
        $a;
    }

        
    public function safeDown()
    {
      return;
    }

}
