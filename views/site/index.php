<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

$action = (isset($_GET['action']))? $_GET['action']:null;

switch ($action){
    case 'placement':
        Yii::$app->response->redirect(['site/placement', 'player' => 'PlayerOne']);
        break;
    case 'battle':
        Yii::$app->response->redirect(['site/battle']);
        break;
    default:
        echo $this->render('greeting');
        break;
}
?>
