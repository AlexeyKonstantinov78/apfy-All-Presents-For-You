<?php

namespace app\modules\root\controllers\shop;

use Yii;
use app\modules\root\controllers\DefaultController;
use app\modules\root\models\Product;
use app\modules\root\models\Shelf;
use app\modules\root\models\ShelfSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShelfController implements the CRUD actions for Shelf model.
 */
class ShelfController extends DefaultController
{
    /**
     * @inheritdoc
     * /
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
     * Lists all Shelf models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShelfSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProduct_find(){
        if(Yii::$app->request->isAjax) {
            $query = Yii::$app->request->post('query');
            //var_dump($query); exit;
            $orderBy = "name";
            $asc = SORT_ASC;
            $likedata[] = ['like', 'name', $query];
            $likedata[] = ['like', 'artid', $query];
            $qmodels = Product::find()->with('seo')->where(array_merge( ['or'],$likedata))->orderBy([$orderBy=>$asc])->asArray()->all();
            //var_dump($qmodels); exit;
            return $this->renderAjax('list_products', [
                'products' => $qmodels,
            ]);
        }
    }
    /**
     * Creates a new Shelf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Shelf();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Deletes an existing Shelf model.
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
     * Finds the Shelf model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shelf the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shelf::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
