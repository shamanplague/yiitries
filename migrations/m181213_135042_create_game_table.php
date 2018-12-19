<?php

use yii\db\Migration;

/**
 * Handles the creation of table `game`.
 */
class m181213_135042_create_game_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('game', [
            'id' => $this->primaryKey(),
            'game_id' => $this->integer(),
            'field_owner' => $this->string(),
            'x' => $this->integer(),
            'y' => $this->integer(),
            'state' => $this->char()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('game');
    }
}
