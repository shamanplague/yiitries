<?php
/**
 * Created by PhpStorm.
 * User: shaman
 * Date: 05.12.18
 * Time: 12:16
 */

namespace app\models;


class Field
{

public $cells;

public function __construct()
{
    for ($i = 0; $i < 10; $i++)
        for ($j = 0; $j < 10; $j++)
            $this->cells[$i][$j] = 'e';
}

}