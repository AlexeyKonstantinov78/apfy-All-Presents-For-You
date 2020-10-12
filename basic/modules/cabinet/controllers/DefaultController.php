<?php

namespace app\modules\cabinet\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Default controller for the `cabinet` module
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
                        'allow' => (!\Yii::$app->user->isGuest && !\Yii::$app->user->identity->is_root()),
                    ],
                ],
            ],
        ];
    }
    public function init(){
        parent::init();
        if(\Yii::$app->user->isGuest || \Yii::$app->user->identity->is_root()){
            //var_dump(\Yii::$app->user->identity->is_root()); exit;
            //var_dump(\Yii::$app->user->isGuest); exit;
            return $this->goHome();
        }
        $this->layout = 'main';
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
