<?php

use yii\db\Migration;


class m180904_162853_insert_tournament extends Migration
{
 
    public function safeUp()
    {
        $this->insert('tournaments', [
            'name' => 'The International',
            'game_id' => 1,
            'user_id' => 1,
            'format' => 1,
            'rules' => 'United States',
            'prizes' => 'United States',
            'start_date' => date('Y-m-d H:i:s', strtotime('-2 day')),
            'match_schedule' => 7,
            'max_players' => 4,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

        $this->insert('tournaments', [
            'name' => 'WESG 2018',
            'game_id' => 1,
            'user_id' => 1,
            'format' => 2,
            'rules' => 'United States',
            'prizes' => 'United States',
            'start_date' => date('Y-m-d H:i:s', strtotime('+2 day')),
            'match_schedule' => 7,
            'max_players' => 4,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

        $this->insert('tournaments', [
            'name' => 'Mars Dota League',
            'game_id' => 1,
            'user_id' => 1,
            'format' => 3,
            'rules' => 'United States',
            'prizes' => 'United States',
            'start_date' => date('Y-m-d H:i:s', strtotime('+2 day')),
            'match_schedule' => 7,
            'max_players' => 4,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

        $this->insert('tournaments', [
            'name' => 'The Summit',
            'game_id' => 1,
            'user_id' => 1,
            'format' => 4,
            'rules' => 'United States',
            'prizes' => 'United States',
            'start_date' => date('Y-m-d H:i:s', strtotime('+2 day')),
            'match_schedule' => 7,
            'max_players' => 4,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
            'league_p' => 4,
        ]);

        $this->insert('tournaments', [
            'name' => 'Sunrise Cup',
            'game_id' => 1,
            'user_id' => 1,
            'format' => 5,
            'rules' => 'United States',
            'prizes' => 'United States',
            'start_date' => date('Y-m-d H:i:s', strtotime('+2 day')),
            'match_schedule' => 7,
            'max_players' => 4,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
            'league_p' => 2,
            'league_g' => 4,
        ]);


/////////////////////////////////////////////////////////////

        $this->insert('teams', [
            'name' => 'The Bears',
            'slug' => 'the-bears',
            'logo' => '/images/test_logo/logo1.png',
            'background' => '/images/test_logo/bac.png',
            'game_id' => 1,
            'capitan' => 2,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

        $this->insert('teams', [
            'name' => 'Grasshoppers',
            'logo' => '/images/test_logo/logo2.png',
            'background' => '/images/test_logo/bac.png',
            'game_id' => 1,
            'capitan' => 2,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

        $this->insert('teams', [
            'name' => 'Ancient Greeks',
            'slug' => 'ancient-greeks',
            'logo' => '/images/test_logo/logo3.png',
            'background' => '/images/test_logo/bac.png',
            'game_id' => 1,
            'capitan' => 2,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

        $this->insert('teams', [
            'name' => 'Athletic Brotherhood',
            'slug' => 'athletic-brotherhood',
            'logo' => '/images/test_logo/logo4.png',
            'background' => '/images/test_logo/bac.png',
            'game_id' => 1,
            'capitan' => 2,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

        $this->insert('teams', [
            'name' => 'Druzhina',
            'slug' => 'druzhina',
            'logo' => '/images/test_logo/logo5.png',
            'background' => '/images/test_logo/bac.png',
            'game_id' => 1,
            'capitan' => 2,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

        $this->insert('teams', [
            'name' => 'Udaltsy',
            'slug' => 'udaltsy',
            'logo' => '/images/test_logo/logo6.png',
            'background' => '/images/test_logo/bac.png',
            'game_id' => 1,
            'capitan' => 2,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

        $this->insert('teams', [
            'name' => 'Adrenalin',
            'slug' => 'adrenalin',
            'logo' => '/images/test_logo/logo7.png',
            'background' => '/images/test_logo/bac.png',
            'game_id' => 1,
            'capitan' => 2,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

        $this->insert('teams', [
            'name' => 'Arrow',
            'slug' => 'arrow',
            'logo' => '/images/test_logo/logo8.png',
            'background' => '/images/test_logo/bac.png',
            'game_id' => 1,
            'capitan' => 2,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

/////////////////////////////////////////////////////////
        
        for ($i=1; $i < 6; $i++) {
            for ($c=1; $c < 9; $c++) { 
                $this->insert('tournament_team', [
                    'tournament_id' => $i,
                    'team_id' => $c,
                    'status' => 2,
                ]);
            }
        }
    }

   
    public function safeDown()
    {
        echo "m180904_162853_tournaments_teams_data cannot be reverted.\n";

        return false;
    }

    
}
