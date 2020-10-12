<?php

namespace app\modules\cabinet\controllers;


use Yii;
use app\modules\cabinet\models\LoginForm;
use yii\web\Controller;
//use app\modules\cabinet\controllers\DefaultController;

/**
 * Default controller for the `admin` module
 */
class AuthController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function init()
    {
        parent::init();
        if(!\Yii::$app->user->isGuest){
            if(\Yii::$app->user->identity->is_root())
                return $this->redirect('/root/');
            return $this->redirect('/cabinet/');
        }
    }

    public function actionIndex()
    {

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(\Yii::$app->user->identity->is_root())
                return $this->redirect('/root/');
            else
                return $this->redirect('/cabinet/');
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
