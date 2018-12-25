<?php
/**
 * Created by PhpStorm.
 * User: shaman
 * Date: 13.12.18
 * Time: 14:05
 */

namespace app\models;

class Cell
{
    private $x;
    private $y;
    private $state;

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
        $this->state = 'e';
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    public function getCell()
    {

        $cell['x'] = $this->getX();
        $cell['y'] = $this->getY();
        $cell['state'] = $this->getState();
        return $cell;

    }


}