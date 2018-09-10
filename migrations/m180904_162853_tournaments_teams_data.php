<?php

use yii\db\Migration;

/**
 * Class m180904_162853_tournaments_teams_data
 */
class m180904_162853_tournaments_teams_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('tournaments', [
            'name' => 'The International',
            'game_id' => 1,
            'user_id' => 1,
            'format' => 1,
            'rules' => 'United States',
            'prizes' => 'United States',
            'start_date' => '2018-08-14 02:45:00',
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
            'start_date' => '2018-08-14 02:45:00',
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
            'start_date' => '2018-08-14 02:45:00',
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
            'start_date' => '2018-08-14 02:45:00',
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
            'start_date' => '2018-08-14 02:45:00',
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
            'league_p' => 2,
            'league_g' => 4,
        ]);


/////////////////////////////////////////////////////////////

        $this->insert('teams', [
            'name' => 'The Bears',
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
            'logo' => '/images/test_logo/logo3.png',
            'background' => '/images/test_logo/bac.png',
            'game_id' => 1,
            'capitan' => 2,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

        $this->insert('teams', [
            'name' => 'Athletic Brotherhood',
            'logo' => '/images/test_logo/logo4.png',
            'background' => '/images/test_logo/bac.png',
            'game_id' => 1,
            'capitan' => 2,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

        $this->insert('teams', [
            'name' => 'Druzhina',
            'logo' => '/images/test_logo/logo5.png',
            'background' => '/images/test_logo/bac.png',
            'game_id' => 1,
            'capitan' => 2,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

        $this->insert('teams', [
            'name' => 'Udaltsy',
            'logo' => '/images/test_logo/logo6.png',
            'background' => '/images/test_logo/bac.png',
            'game_id' => 1,
            'capitan' => 2,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

        $this->insert('teams', [
            'name' => 'Adrenalin',
            'logo' => '/images/test_logo/logo7.png',
            'background' => '/images/test_logo/bac.png',
            'game_id' => 1,
            'capitan' => 2,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

        $this->insert('teams', [
            'name' => 'Arrow',
            'logo' => '/images/test_logo/logo8.png',
            'background' => '/images/test_logo/bac.png',
            'game_id' => 1,
            'capitan' => 2,
            'created_at' => 1534947950,
            'updated_at' => 1534947950,
        ]);

/////////////////////////////////////////////////////////
        
        for ($i=1; $i < 6; $i++) {
            for ($c=3; $c < 11; $c++) { 
                $this->insert('tournament_team', [
                    'tournament_id' => $i,
                    'team_id' => $c,
                    'status' => 2,
                ]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180904_162853_tournaments_teams_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180904_162853_tournaments_teams_data cannot be reverted.\n";

        return false;
    }
    */
}
