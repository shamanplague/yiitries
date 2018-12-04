<?php

namespace app\models;

use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: shaman
 * Date: 01.12.18
 * Time: 11:37
 */

class game extends Model
{
    public $users_field;
    public $ai_field;
    public $current_player = 'ai';

    public function __construct()
    {

        $this->users_field = ["s", "e", "e", "e", "e", "e", "e", "e", "e", "e"];
        $this->users_field = ["s", "e", "s", "s", "s", "e", "e", "e", "s", "e"];
        $this->users_field = ["s", "e", "e", "e", "e", "e", "e", "e", "s", "e"];
        $this->users_field = ["s", "e", "s", "s", "s", "e", "e", "e", "e", "e"];
        $this->users_field = ["e", "e", "e", "e", "e", "e", "e", "e", "e", "e"];
        $this->users_field = ["e", "e", "e", "e", "e", "s", "e", "s", "e", "e"];
        $this->users_field = ["e", "s", "e", "e", "e", "e", "e", "e", "e", "e"];
        $this->users_field = ["e", "s", "e", "s", "e", "e", "e", "e", "e", "e"];
        $this->users_field = ["e", "e", "e", "e", "e", "e", "e", "e", "e", "s"];
        $this->users_field = ["s", "e", "e", "e", "e", "e", "e", "e", "e", "s"];

        $this->ai_field = ["s", "e", "e", "s", "e", "e", "s", "e", "e", "e"];
        $this->ai_field = ["s", "e", "e", "e", "e", "e", "s", "e", "e", "e"];
        $this->ai_field = ["e", "e", "e", "s", "e", "e", "e", "e", "s", "e"];
        $this->ai_field = ["e", "e", "e", "s", "e", "e", "e", "e", "e", "e"];
        $this->ai_field = ["e", "e", "e", "e", "e", "e", "e", "s", "e", "e"];
        $this->ai_field = ["e", "e", "s", "s", "s", "e", "e", "s", "e", "e"];
        $this->ai_field = ["s", "e", "e", "e", "e", "e", "e", "s", "e", "e"];
        $this->ai_field = ["e", "e", "e", "e", "e", "e", "e", "e", "e", "e"];
        $this->ai_field = ["e", "e", "e", "e", "e", "e", "s", "e", "e", "e"];
        $this->ai_field = ["s", "s", "s", "s", "e", "e", "e", "e", "e", "e"];

    }

    public function winner()

    {

        $result_string = '';

        foreach ($this->users_field as $row) {
            foreach ($row as $cell) {
                $result_string .= $cell;
            }
        }

        if (stripos($result_string, 's') === false) return 'AI won!';

        $result_string = '';

        foreach ($this->ai_field as $row) {
            foreach ($row as $cell) {
                $result_string .= $cell;
            }
        }

        if (stripos($result_string, 's') === false) return 'User won!';

        return false;
    }

    public function changePlayer()
    {
        $this->current_player = ($this->current_player == 'user')? 'ai':'user';
    }

    public function aiMove()
    {
        echo 'ai_move_pre';

        $x = rand(0, 9);
        $y = rand(0, 9);

        echo 'ai_move x='.$x.'y='.$y;

        $this->users_field[$x][$y] = 'c';

    }

}