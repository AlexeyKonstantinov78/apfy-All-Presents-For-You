<?php

namespace app\modules\shop\controllers;

use Yii;
use app\models\ArticleCategory;
use app\models\Articles;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class ArticlecategoryController extends Controller
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $tree = ArticleCategory::generateTree();
		return $this->render('index', [
            'tree' => $tree,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($slug)
    {
		$model = $this->findModel($slug);		
		$query = Articles::find()->joinWith(['articleincategory'])->where(['id_article_category'=>$model->id])->with(['seo','mainimage']);
		
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize'=>9]);
		$articles = $query->offset($pages->offset)->limit($pages->limit)->all();
		
        return $this->render('view', [
            'model' => $model,
			'articles' => $articles,
			'pages' => $pages,
        ]);
    }




    protected function findModel($slug)
    {
        if (($model = ArticleCategory::findSlug($slug)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
