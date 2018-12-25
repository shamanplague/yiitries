<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Game;

class BattleController extends Controller
{
    private function startPlacement($player)
    {

        $decking = [4, 3, 3, 2, 2, 2, 1, 1, 1, 1];

        while ($currentDecking = array_shift($decking)) {

            echo "Расстановка кораблей игрока " . $player . "\n\n";

            $recievedField = $this->getField($player);

            $count = 0;
            $rowNumber = 0;

            echo "* A B C D E F G H I J";
            foreach ($recievedField as $cell) {
                if ($count % 10 == 0) {
                    echo "\n" . $rowNumber . ' ';
                    $rowNumber++;
                };
                echo $cell->getState() . " ";
                $count++;
            }

            echo "\n\n";

            do {
                echo "Укажите следующую палубу в формате 'xyd', где\r\n" .
                    " x - координата строки \r\n y - координата столбца \r\n" .
                    " d - направление (v - для вертикального расположения, h - для горизонтального): \n";

                $move = readline();

            } while (!preg_match('/^[a-j]\d[vh]$/', $move));

            $y = (integer)ord(substr($move, 0, 1)) - 97;
            $x = (integer)substr($move, 1, 1);
            $direction = substr($move, 2, 1);

            $ship = [];

            if ($direction == 'h') {
                for ($i = 0; $i < $currentDecking; $i++) {
                    $ship[] = array("x" => $x, "y" => $y + $i);
                }

                $this->placeShip($ship, $player);

                system('clear');
            } else {
                for ($i = 0; $i < $currentDecking; $i++) {
                    $ship[] = array("x" => $x + $i, "y" => $y);
                }

                $this->placeShip($ship, $player);

                system('clear');
            }


        }
    }

    private function getField($player)

    {

        $currentGame = Game::getGame(0);

        return $currentGame->defineField($player)->getCells();

    }

    private function placeShip($ship, $player)

    {

        $currentGame = Game::getGame(0);

        foreach ($ship as $deck) {

            $currentGame->defineField($player)->updateCell($deck['x'], $deck['y'], 's');

        }

    }

    private function paintFields($currentPlayer)
    {

        $nextPlayer = ($currentPlayer == 'PlayerOne') ? 'PlayerTwo' : 'PlayerOne';

        echo "Ход " . $currentPlayer . "\n";

        echo "Ваше поле: \n";

        $recievedField = $this->getField($currentPlayer);

        $count = 0;
        $rowNumber = 0;

        echo "* A B C D E F G H I J";
        foreach ($recievedField as $cell) {
            if ($count % 10 == 0) {
                echo "\n" . $rowNumber . ' ';
                $rowNumber++;
            };
            echo $cell->getState() . " ";
            $count++;
        }

        echo "\n\n";

        echo "Поле соперника: \n";

        $recievedField = $this->getField($nextPlayer);

        $count = 0;
        $rowNumber = 0;

        echo "* A B C D E F G H I J";
        foreach ($recievedField as $cell) {
            if ($count % 10 == 0) {
                echo "\n" . $rowNumber . ' ';
                $rowNumber++;
            }
            if ($cell->getState() == 's') {
                echo 'e ';
            } else {
                echo $cell->getState() . " ";
            }
            $count++;
        }

        echo "\n\n";

        do {
            echo "Укажите клетку в формате 'xy', где\r\n x - координата строки \r\n y - координата столбца\n";
            $move = readline();
        } while (!preg_match('/^[a-j]\d$/', $move));

        $x = substr($move, 1, 1);
        $y = (integer)ord(substr($move, 0, 1)) - 97;

        system('clear');

        $currentGame = Game::getGame(0);

        $hitResult = $currentGame->getHitResult($x, $y, $nextPlayer);

        if ($hitResult == 'c') {
            echo "Попадание!\n";
        } else {
            echo "Промах!\n";
        }

        return $hitResult;

    }


    public function actionBattle()
    {
        system('clear');

        $currentGame = new Game;

        $currentGame->write();

        $this->startPlacement('PlayerOne');

        $this->startPlacement('PlayerTwo');


        echo "Расстановка закончена!\n";

        while (!$currentGame->getWinner()) {
            do {
                $hitResult = $this->paintFields('PlayerOne');
            } while ($hitResult == 'c' && !$currentGame->getWinner());

            if ($currentGame->getWinner()) break;

            do {
                $hitResult = $this->paintFields('PlayerTwo');
            } while ($hitResult == 'c' && !$currentGame->getWinner());
        }

        echo "Победил " . $currentGame->getWinner() . "\n";

    }

}