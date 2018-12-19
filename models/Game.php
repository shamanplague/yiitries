<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: shaman
 * Date: 01.12.18
 * Time: 11:37
 */

class Game extends ActiveRecord
{

    public $fieldForPlayerOne;
    public $fieldForPlayerTwo;

    public function __construct()
    {
        parent::__construct();

        $this->fieldForPlayerOne = new Field('PlayerOne');
        $this->fieldForPlayerTwo = new Field('PlayerTwo');

    }

    public static function getGame($id){

        $game = new Game;

        $recivedFieldForPlayerOne = Game::find()
            ->where([
                'field_owner' => $game->fieldForPlayerOne->getOwner(),
                'game_id' => $id])
            ->select(['x','y','state'])
            ->asArray()
            ->orderBy('id')
            ->all();

        foreach ($recivedFieldForPlayerOne as $cell) {
            $x = $cell['x'];
            $y = $cell['y'];
            $state = $cell['state'];

            $game->fieldForPlayerOne->updateCell($x, $y, $state);

        }


        $recivedFieldForPlayerTwo = Game::find()
            ->where([
                'field_owner' => $game->fieldForPlayerTwo->getOwner(),
                'game_id' => $id])
            ->select(['x','y','state'])
            ->asArray()
            ->orderBy('id')
            ->all();


        foreach ($recivedFieldForPlayerTwo as $cell) {
            $x = $cell['x'];
            $y = $cell['y'];
            $state = $cell['state'];

            $game->fieldForPlayerTwo->updateCell($x, $y, $state);

        }

        return $game;
    }

    public function hitResult($x, $y, $player)
    {
        switch ($player){
            case 'PlayerOne':

                $cells = $this->fieldForPlayerOne->getCells();

                foreach ($cells as $cell){
                    if (($cell->getX() == $x) && ($cell->getY() == $y)){
                        if ($cell->getState() == 's')
                        {
                            $cell->setState('c');
                        }
                        else
                        {
                            $cell->setState('m');
                        }

                        return $cell->getState();
                    }
                }

                break;

            case 'PlayerTwo':

                $cells = $this->fieldForPlayerTwo->getCells();

                foreach ($cells as $cell){
                    if (($cell->getX() == $x) && ($cell->getY() == $y)){
                        if ($cell->getState() == 's')
                        {
                            $cell->setState('c');
                        }
                        else
                        {
                            $cell->setState('m');
                        }

                        return $cell->getState();

                    }
                }

                break;
        }

        return 'x='.$x.'y='.$y.'player='.$player;
    }

    public function getWinner()

    {

        $result = Game::find()->where([
            'state' => 's',
            'field_owner' => 'PlayerTwo'
        ])->asArray()->count();

        if($result == 0)
        {
            return 'PlayerOne';
        }
        else
        {
            $result = Game::find()->where([
                'state' => 's',
                'field_owner' => 'PlayerOne'
            ])->asArray()->count();

            if($result == 0)
            {
                return 'PlayerTwo';
            }
            else
            {
                return false;
            }

        }

    }

    public function write()
    {

        Yii::$app->db->createCommand(
            "DELETE FROM game WHERE id > 0"
        )->execute();

        $cells = $this->fieldForPlayerOne->getCells();

        foreach ($cells as $cell){
            Yii::$app->db->createCommand(
                "INSERT INTO game (game_id, field_owner, x, y, state) VALUES (0, '".
                $this->fieldForPlayerOne->getOwner()."', ".
                $cell->getX().", " .
                $cell->getY().", '" .
                $cell->getState()."')"
            )->execute();
        }


//        Yii::$app->db->createCommand(
//            "DELETE FROM game WHERE field_owner='".$this->fieldForPlayerTwo->getOwner()."'"
//        )->execute();

        $cells = $this->fieldForPlayerTwo->getCells();

        foreach ($cells as $cell){
            Yii::$app->db->createCommand(
                "INSERT INTO game (game_id, field_owner, x, y, state) VALUES (0, '".
                $this->fieldForPlayerTwo->getOwner()."', ".
                $cell->getX().", " .
                $cell->getY().", '" .
                $cell->getState()."')"
            )->execute();
        }

    }

}