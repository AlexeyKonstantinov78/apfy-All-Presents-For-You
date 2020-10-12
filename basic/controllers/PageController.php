<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Settings;
use app\models\Maps;
use app\models\Page;
use yii\helpers\ArrayHelper;
class PageController extends Controller
{
   //public $layout = 'index';

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex($slug = '')
    {
		if($slug == '') return $this->redirect("/");
		$model = $this->findModel($slug);		

		if(Yii::$app->request->isAjax){
            return $this->renderAjax('ajax', [
                'model' => $model,
            ]);
        }
        if($model->template == '') $model->template = 'index';
        return $this->render($model->template, [
            'model' => $model,
        ]);
    }
	
	
	protected function findModel($slug)
    {
        if (($model = Page::findSlug($slug)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
}
