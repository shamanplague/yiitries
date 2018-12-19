<?php
/**
 * Created by PhpStorm.
 * User: shaman
 * Date: 05.12.18
 * Time: 12:16
 */

namespace app\models;

use Yii;

class Field
{
const DIMENTION = 10;
private $cells;
private $owner;

public function __construct($user)
{

    $this->owner = $user;


    for ($x = 0; $x < self::DIMENTION; $x++)
        for ($y = 0; $y < self::DIMENTION; $y++)
            $this->cells[] = new Cell($x, $y);
}

    /**
     * @return Cell
     */
    public function getCells()
    {
        return $this->cells;
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    public function updateCell($x, $y, $state)
    {
        $cells = $this->getCells();

        foreach ($cells as $cell){
            if (($cell->getX() == $x) && ($cell->getY() == $y))
                $cell->setState($state);
        }

    }

    public function writeCell(){

    }

}