<?php

namespace app\controllers;

use Yii;
use app\models\ArticleCategory;
use app\models\Articles;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * ProductController implements the CRUD actions for Product model.
 */
class ArticlesController extends Controller
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
     * Displays a single Articles model.
     * @param integer $id
     * @return mixed
     */
    public function actionIndex($slug)
    {
        return $this->render('view', [
            'model' => $this->findModel($slug),
        ]);
    }
	
	public function actionView($slug)
    {
		$model = $this->findCatgoryModel($slug);		
		$query = Articles::find()->joinWith(['articleincategory'])->where(['id_article_category'=>$model->id, 'active' => 1])->with(['seo','main_image']);
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize'=>9]);
		$articles = $query->orderBy(["id"=>SORT_DESC])->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('category', [
            'model' => $model,
			'articles' => $articles,
			'pages' => $pages,
        ]);
    }

    
    protected function findModel($slug)
    {
        if (($model = Articles::findSlug($slug)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findCatgoryModel($slug)
    {
        if (($model = ArticleCategory::findSlug($slug)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
