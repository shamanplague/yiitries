<?php

use app\models\Game;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

$action = (isset($_GET['action']))? $_GET['action']:null;

switch ($action){
    case 'placement':
        Yii::$app->response->redirect(['site/placement']);
        break;
    case 'battle':
        Yii::$app->response->redirect(['site/battle']);
        break;
    case 'move':
        Yii::$app->response->redirect(['site/battle', 'x' => $_GET['x'], 'y' => $_GET['y']]);
        break;
    default:
        echo $this->render('greeting');
        break;
}