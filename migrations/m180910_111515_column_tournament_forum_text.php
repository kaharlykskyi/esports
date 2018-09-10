<?php

use yii\db\Migration;

/**
 * Class m180910_111515_column_tournament_forum_text
 */
class m180910_111515_column_tournament_forum_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tournaments', 'forum_text', $this->text()->Null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tournaments', 'forum_text');
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
