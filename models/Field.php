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

    public function updateCell($x, $y, $state)
    {

        foreach ($this->cells as $cell) {
            if (($cell->getX() == $x) && ($cell->getY() == $y))
                $cell->setState($state);
        }

        $cellForUpdate = Game::findOne(['field_owner' => $this->owner, 'x' => $x, 'y' => $y]);
        $cellForUpdate->state = $state;
        $cellForUpdate->update();

    }

    public function isAvailable($ship)
    {

        $firstDeck = reset($ship);
        $lastDeck = end($ship);
        $decking = count($ship);
        $vertical = ($firstDeck['x'] == $lastDeck['x']) ? false : true;

        $startPositionX = $firstDeck['x'] - 1;
        $startPositionY = $firstDeck['y'] - 1;

        if ($vertical) {

            for ($y = $startPositionY; $y < $startPositionY + 3; $y++) {
                for ($x = $startPositionX; $x < $startPositionX + $decking + 2; $x++) {
                    if ($x < 0 || $y < 0 || $x == 10 || $y == 10) continue;
                    if ($x > 10 || $y > 10) return false;

                    foreach ($this->cells as $cell) {
                        if (($cell->getX() == $x) && ($cell->getY() == $y)) {
                            if ($cell->getState() == 's') return false;
                        }
                    }
                }
            }
        } else {

            for ($x = $startPositionX; $x < $startPositionX + 3; $x++) {
                for ($y = $startPositionY; $y < $startPositionY + $decking + 2; $y++) {
                    if ($x < 0 || $y < 0 || $x == 10 || $y == 10) continue;
                    if ($x > 10 || $y > 10) return false;

                    foreach ($this->cells as $cell) {
                        if (($cell->getX() == $x) && ($cell->getY() == $y)) {
                            if ($cell->getState() == 's') return false;
                        }
                    }
                }
            }

        }

        return true;

    }

}