<?php

namespace app\controllers;

use app\models\Cell;
use app\models\Ship;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\Game;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Форма регистрации.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionGreeting()
    {
        return $this->render('greeting');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()

    {
        return $this->render('about');
    }

    public function actionPlacement()

    {
        $this->layout = 'placement_view';

        $player = (isset($_GET['player'])) ? $_GET['player'] : null;

        if ($player == 'PlayerOne') {
            $game = new Game;
            $game->write();
        }

        return $this->render('placement');
    }


    public function actionGetfield()

    {
        $player = (isset($_GET['player'])) ? $_GET['player'] : null;

        $currentGame = Game::getGame(0);
        $recievedField = $currentGame->defineField($player)->getCells();
        foreach ($recievedField as $cell) {
            $field[] = $cell->getCell();
        }

        return json_encode($field);

    }

    public function actionPlaceship()

    {


        $ship = (isset($_POST['ship'])) ? json_decode($_POST['ship'], true) : null;
        $player = (isset($_POST['player'])) ? $_POST['player'] : null;

        $currentGame = Game::getGame(0);

        if ($currentGame->defineField($player)->isAvailable($ship)) {

            foreach ($ship as $deck) {
                $currentGame->defineField($player)->updateCell($deck['x'], $deck['y'], 's');
            }

            return 'Success!';

        }

        return false;

    }

    public function actionBattle()
    {

        return $this->render('battle');
    }

    public function actionHitresult()
    {
        $x = (isset($_GET['x'])) ? $_GET['x'] : null;
        $y = (isset($_GET['y'])) ? $_GET['y'] : null;
        $player = (isset($_GET['player'])) ? $_GET['player'] : null;

        $currentGame = Game::getGame(0);
        $result = $currentGame->getHitResult($x, $y, $player);

        return $result;

    }

    public function actionGetwinner()
    {
        $currentGame = Game::getGame(0);
        return $currentGame->getWinner();
    }

}
