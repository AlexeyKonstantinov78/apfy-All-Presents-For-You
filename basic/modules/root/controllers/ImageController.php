<?php
namespace app\modules\root\controllers;
use Yii;
use app\models\Images;
use yii\web\NotFoundHttpException;
use app\modules\root\controllers\DefaultController;


class ImageController extends DefaultController
{
	public function actionDelete()
    {
		
		if(Yii::$app->request->isAjax){
			//$this->Images->
			//if($this->findModel(Yii::$app->request->post()['id'])->delete()) return true;
			return true;
		}
		return false;
	}
	
	protected function findModel($id)
    {
        if (($model = Images::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}	
