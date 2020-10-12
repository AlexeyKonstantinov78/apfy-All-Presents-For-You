<?php

namespace app\modules\root\controllers;

use Yii;
use app\models\BannerElements;
use yii\data\ActiveDataProvider;
use app\modules\root\controllers\DefaultController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BannerElementsController implements the CRUD actions for BannerElements model.
 */
class BannerelementsController extends DefaultController
{
    /**
     * @inheritdoc
     */
	protected $parent_id; 
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all BannerElements models.
     * @return mixed
     */
    public function actionIndex()
    {
		if(Yii::$app->request->get('id')) {
			$this->parent_id = Yii::$app->request->get('id');
			$dataProvider = new ActiveDataProvider([
				'query' => BannerElements::find()->where(['parent_id' => Yii::$app->request->get('id')]),
				'sort'=> ['defaultOrder' => ['sort'=>SORT_ASC]],
			]);
				return $this->render('index', [
				'dataProvider' => $dataProvider,
				'id' => Yii::$app->request->get('id'),
			]);
		} else {
			return $this->redirect('/root/bannergroups/');
		}
    }

    /**
     * Creates a new BannerElements model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		if(Yii::$app->request->get('id')){
			$g = Yii::$app->request->get('id');
		}
		else {
			return $this->redirect('/root/bannergroups/');
		}
        $model = new BannerElements(['parent_id' => $g]);
        if ($model->load(Yii::$app->request->post()) && $model->moveFirst()->save()) {
            return $this->redirect(['index', 'id' => $model->parent_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BannerElements model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->parent_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionSortorder()
    {
        
        if(Yii::$app->request->isAjax){
			
			$p = Yii::$app->request->post();
			$model1 = $this->findModel($p['first_id']);
			$model2 = $this->findModel($p['second_id']);
			//$model1->parent_id = $model2->parent_id; 
			if($p['act'] == 'after') {
				$model1->moveAfter($model2)->save();
			} else {
				$model1->moveBefore($model2)->save();
			}
			return 'eys';
		}
		return 'net';
    }
	
    /**
     * Deletes an existing BannerElements model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BannerElements model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BannerElements the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BannerElements::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
