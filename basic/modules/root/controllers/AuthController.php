<?php

namespace app\modules\root\controllers;


use Yii;
use app\modules\root\models\RootForm;
use yii\web\Controller;
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
    } 
	 
	public function actionIndex()
    {
		if (!Yii::$app->user->isGuest) {
            return $this->redirect('/root/');
        }
		$model = new RootForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->redirect('/root/');
		}
        return $this->render('index', [
			'model' => $model,
		]);
    }
}
