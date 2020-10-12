<?php

namespace app\modules\root\controllers;

use Yii;
use app\models\ArticleCategory;
use yii\data\ActiveDataProvider;
use app\modules\root\controllers\DefaultController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
/**
 * Article_categoryController implements the CRUD actions for ArticleCategory model.
 */
class ArticlecategoryController extends DefaultController
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
     * Lists all ArticleCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new ArticleCategory();
        $tree = $model->generateTreeJs();


        return $this->render('index', [
            'model' => $model,
            'tree' => $tree,
        ]);
    }

    /**
     * Displays a single ArticleCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        //$var_dump($id);
        //exit();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ArticleCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticleCategory(['active'=>'1']);
        if ($model->load(Yii::$app->request->post()) && $model->makeRoot()->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ArticleCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        //var_dump(Yii::$app->request->post()['submit-button']);
        //exit();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if($model->save() && isset(Yii::$app->request->post()['submit-button'])) {
                return $this->redirect('/root/articlecategory');
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
     * Deletes an existing ArticleCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->post()['id'];
        $this->findModel($id)->deleteWithChildren();
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['message'=>true];
    }

    /**
     * Finds the ArticleCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArticleCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticleCategory::find()->where(['id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionAddchild()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax && Yii::$app->request->post()) {
            $model = new ArticleCategory();
            $post = Yii::$app->request->post();
            $parent = $this->findModel($post['parent_id']);
            if($parent != null)
            {
                $model->name = $post['name'];
                $model->parent_id = $post['parent_id'];
                $model->appendTo($parent)->save();
            }
            return $model;
        }
    }
}
