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
//        $this->users_field = new Field();
//        $this->ai_field = new Field();


        $this->users_field[0] = ["s", "e", "e", "e", "e", "e", "e", "e", "e", "e"];
        $this->users_field[1] = ["s", "e", "s", "s", "s", "e", "e", "e", "s", "e"];
        $this->users_field[2] = ["s", "e", "e", "e", "e", "e", "e", "e", "s", "e"];
        $this->users_field[3] = ["s", "e", "s", "s", "s", "e", "e", "e", "e", "e"];
        $this->users_field[4] = ["e", "e", "e", "e", "e", "e", "e", "e", "e", "e"];
        $this->users_field[5] = ["e", "e", "e", "e", "e", "s", "e", "s", "e", "e"];
        $this->users_field[6] = ["e", "s", "e", "e", "e", "e", "e", "e", "e", "e"];
        $this->users_field[7] = ["e", "s", "e", "s", "e", "e", "e", "e", "e", "e"];
        $this->users_field[8] = ["e", "e", "e", "e", "e", "e", "e", "e", "e", "s"];
        $this->users_field[9] = ["s", "e", "e", "e", "e", "e", "e", "e", "e", "s"];

        $this->ai_field[0] = ["s", "e", "e", "s", "e", "e", "s", "e", "e", "e"];
        $this->ai_field[1] = ["s", "e", "e", "e", "e", "e", "s", "e", "e", "e"];
        $this->ai_field[2] = ["e", "e", "e", "s", "e", "e", "e", "e", "s", "e"];
        $this->ai_field[3] = ["e", "e", "e", "s", "e", "e", "e", "e", "e", "e"];
        $this->ai_field[4] = ["e", "e", "e", "e", "e", "e", "e", "s", "e", "e"];
        $this->ai_field[5] = ["e", "e", "s", "s", "s", "e", "e", "s", "e", "e"];
        $this->ai_field[6] = ["s", "e", "e", "e", "e", "e", "e", "s", "e", "e"];
        $this->ai_field[7] = ["e", "e", "e", "e", "e", "e", "e", "e", "e", "e"];
        $this->ai_field[8] = ["e", "e", "e", "e", "e", "e", "s", "e", "e", "e"];
        $this->ai_field[9] = ["s", "s", "s", "s", "e", "e", "e", "e", "e", "e"];

    }

    public function hitResult($row, $col){

        if ($this->ai_field[$row][$col] == 's')
            $this->ai_field[$row][$col] = 'c';
        else
            $this->ai_field[$row][$col] = 'm';
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