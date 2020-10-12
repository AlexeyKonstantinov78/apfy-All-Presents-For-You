<?php

namespace app\modules\root\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */




    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->is_root()),
                    ],
                ],
            ],
        ];
    }

    public function init(){
        parent::init();
        if(\Yii::$app->user->isGuest)
            return $this->goHome();
        if (!\Yii::$app->user->identity->is_root()){
            return $this->goHome();
        }
    }

    public function actionIndex()
    {

        return $this->render('index');
    }
}
