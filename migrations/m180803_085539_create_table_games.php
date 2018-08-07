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
        ]);

        $this->insert('games', [
            'name' => 'HearthStone',
            'logo' =>'hart5-0.jpg',
        ]);
        $this->insert('games', [
            'name' => 'Pokémon',
            'logo' =>'pokemon.jpg',
        ]);
        $this->insert('games', [
            'name' => 'World of Warcraft',
            'logo' =>'photo1.jpg',
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
