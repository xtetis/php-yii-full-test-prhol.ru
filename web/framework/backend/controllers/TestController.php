<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Apple;
use yii\filters\AccessControl;

/**
 * Контроллер для выполнения тестовой задачи
 */
class TestController extends Controller
{
    /**
     * Запрещаем вход неавторизированным
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
     * Отображает список сгенерированных яблок
     */
    public function actionIndex()
    {
        return $this->render('index', ['apples'=>Apple::getAll()]);
    }

    /**
     * Добавляет яблоко
     */
    public function actionGenapple()
    {
        new Apple();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['reload_page' => true];
    }

    /**
     * Удадяем все яблоки
     */
    public function actionDelall()
    {
        Apple::deleteAll();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['reload_page' => true];
    }

    /**
     * Удадяем одно яблоко
     */
    public function actionDelone()
    {
        $idx = Yii::$app->request->post('idx', '');
        Apple::getOne($idx)->delete();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['reload_page' => true];
    }

    /**
     * Упасть на землю
     */
    public function actionFalltoground()
    {
        $idx = Yii::$app->request->post('idx', '');
        Apple::getOne($idx)->fallToGround();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['reload_page' => true];
    }

    /**
     * Откусить
     */
    public function actionEat()
    {
        $idx      = Yii::$app->request->post('idx', '');
        $size_eat = intval(Yii::$app->request->post('size_eat', 0));
        Apple::getOne($idx)->eat($size_eat);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['reload_page' => true];
    }

}
