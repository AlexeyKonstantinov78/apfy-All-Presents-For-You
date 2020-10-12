<?php

namespace app\modules\root\controllers;

use Yii;
use app\models\Articles;
use yii\data\ActiveDataProvider;
use app\modules\root\controllers\DefaultController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ArticleCategory;
use app\models\ArticleInCategory;
use yii\helpers\ArrayHelper;
use yii\db\Query;
/**
 * ArticlesController implements the CRUD actions for Articles model.
 */
class ArticlesController extends DefaultController
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
     * Lists all Articles models.
     * @return mixed
     */
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Articles::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Articles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Articles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	public function actionCreate()
    {
		$now_date = date('Y-m-d H:i:s'); 
        $model = new Articles(['active'=>'1', 'date'=> $now_date, 'date_public'=> $now_date ]);
//        var_dump($model);
//        exit;
		$category = new ArticleCategory();
		$tree = $category->generateTreeJs(['expanded'=>'all']);
        if(Yii::$app->request->post()) {
            Yii::$app->request->post()['Articles']['date'] = date('Y-m-d H:i', time(Yii::$app->request->post()['Articles']['date']));
            Yii::$app->request->post()['Articles']['date_public'] = date('Y-m-d H:i', time(Yii::$app->request->post()['Articles']['date_public']));
        }
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                if(isset(Yii::$app->request->post()['ft_1'])){
                    ArticleInCategory::setArticleCategories($model->id,Yii::$app->request->post()['ft_1']);
                }
            }

            return $this->redirect(['index']);
        } else {
			//exit();
            return $this->render('create', [
                'model' => $model,
				'model_seo' => $model->seoTags,
				'tree' => $tree,
            ]);
        }
    }
	 

    /**
     * Updates an existing Articles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
	public function actionUpdate($id)
    {
		$model = $this->findModel($id);
		$category = new ArticleCategory();
		$ids = ArticleInCategory::getArticleCategoriesIds($id);
		$ids = ArrayHelper::getColumn($ids, 'id_article_category');
		$options = ['expanded'=>'all'];
		foreach($ids as $v)
			$options[$v] = ['selected'=>true];
		$tree = $category->generateTreeJs($options);
		if(Yii::$app->request->post()) {
			Yii::$app->request->post()['Articles']['date'] = date('Y-m-d H:i', time(Yii::$app->request->post()['Articles']['date']));
			Yii::$app->request->post()['Articles']['date_public'] = date('Y-m-d H:i', time(Yii::$app->request->post()['Articles']['date_public']));
		}
		if ($model->load(Yii::$app->request->post())){ //&& Model::validateMultiple($model)
			if(!($model->save())) return $this->render('update', [
					'model' => $model,
					'model_seo' => $model->seoTags,
					'tree' => $tree,
				]);
			
			if(isset(Yii::$app->request->post()['ft_1'])){
				ArticleInCategory::setArticleCategories($id,Yii::$app->request->post()['ft_1']);
			}
            return $this->redirect('index');
		} else {
            return $this->render('update', [
                'model' => $model,
				'model_seo' => $model->seoTags,
				'tree' => $tree,
            ]);
        }
		
    } 
	 

    /**
     * Deletes an existing Articles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		ArticleInCategory::deleteAll('id_article = :id', [':id' => $id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
		$model = Articles::find()->where(['id'=>$id])->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetitem($id) {
        $query = Articles::find()->joinWith(['articlecategory'])->where(['id_article_category'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        return $this->renderAjax('list_articles', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
