<?php

namespace app\modules\root\controllers\shop;

use Yii;
use app\modules\shop\models\ProductAttribute;
use yii\data\ActiveDataProvider;
use app\modules\root\controllers\DefaultController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//namespace app\modules\shop\models;
/** 
 * AttributeproductController implements the CRUD actions for AttributeProduct model.
 */
class Product_attributeController extends DefaultController
{
    /**
     * @inheritdoc
     */
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
     * Lists all AttributeProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductAttribute::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AttributeProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductAttribute();
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			if($model->save() && isset(Yii::$app->request->post()['submit-button'])) {
				return $this->redirect('/root/shop/product_attribute');
			} else {
				Yii::$app->response->format = Response::FORMAT_JSON;
				return ActiveForm::validate($model);
			}
		}
        return $this->renderAjax('_form', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing AttributeProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			if($model->save() && isset(Yii::$app->request->post()['submit-button'])) {
				return $this->redirect('/root/shop/product_attribute');
			} else {
				Yii::$app->response->format = Response::FORMAT_JSON;
				return ActiveForm::validate($model);
			}
		}
        return $this->renderAjax('_form', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing AttributeProduct model.
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
     * Finds the AttributeProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AttributeProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductAttribute::find()->where(['id'=>$id,])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
