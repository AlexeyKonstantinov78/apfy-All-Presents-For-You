<?php

namespace app\modules\shop\controllers;

use app\modules\shop\models\Category;
use app\modules\shop\models\elastic\ElasticProduct;
use Yii;
use app\modules\shop\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\elasticsearch;
use yii\elasticsearch\Query;
use yii\elasticsearch\QueryBuilder;
use yii\web\Response;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearchlong(){
        $models = null;
        return $this->render('esearch', [
            'models' => $models,
        ]);
    }

    public function actionSearch($query){
        /**
         * ToDo ToLook
         * как пример, но потом удалить
         *
             * работает
             *
             * /
            $params = [
            'multi_match' => [
                'query' => $query,
                'fields' => [
                    'h1',
                    'name',
                    'artid',
                ],
                'type' => 'best_fields',
                'operator' => 'and',
                'fuzziness' => 'auto',
            ],
        ];

        $params = [
            'multi_match' => [
                'query' => $query,
                'fields' => [
                    'h1',
                    'name',
                    'artid',
                ],
                'type' => 'phrase',
                'boost' => 10,
            ],
        ];
         */
        if(!empty($query)){
            $params = [
                'multi_match' => [
                    'query' => $query,
                    'fields' => [
                        'name',
                        'artid',
                    ],
                    'type' => 'best_fields',
                    'operator' => 'and',
                    'fuzziness' => 'auto',
                ],
            ];
            $models = ElasticProduct::find()
                ->query($params)
                ->highlight([
                    'pre_tags'  => '<em style="color:red">',
                    'post_tags' => '</em>',
                    'fields'    => [
                        'name' => new \stdClass(),
                        'h1'  => new \stdClass(),
                    ]
                ])
                ->limit(400)
                ->asArray()
                ->all();
        } else {
            $models = 'Введите запрос для поиска';
        }

        return $this->render('esearch', [
            'models' => $models,
        ]);
    }

    //ToDo Наверно удалить 16.10.2019
    /*public function actionSearch($query)
    {
        $this->view->title = 'Результат поиска по запросу '.$query;
        $likedata = [];
        if(preg_match("#[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}#", $query)){
            $likedata[] = ['like', 'id_int', $query];
        } else {
            $likedata[] = ['like', 'name', $query];
            $likedata[] = ['like', 'artid', $query];
        }

        $qmodels = Product::find()->with('seo')->where(array_merge( ['or'],$likedata))->andWhere(['>', 'active', 0]);


        $orderBy = "name";
        $asc = SORT_ASC;

        $models = $qmodels->orderBy([$orderBy=>$asc])->all();

        return $this->render('search', [
            'models' => $models,
        ]);

    }*/

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($slug)
    {
        $model = $this->findModel($slug);
        //var_dump($model->id); exit;
        if($model->active == 0) return $this->goHome();
        $brand = Category::find()->joinWith('products')->where(['product.id' => $model->id, 'is_brand' => 1])->one();

        /*var_dump($brand);
        exit;*/
        return $this->render('view', [
            'model' => $model,
            'brand' => $brand
        ]);
    }

    public function actionAjaxProduct($id){
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(Yii::$app->request->isAjax) {
            $result =Product::findOne(['id' => $id]);
            if(!empty($result->discount_price) && $result->discount_price > 0) $result->price = $result->discount_price;
            $result = [
                'id' => $result->id,
                'name' => !empty($result->seoTags->h1) ? $result->seoTags->h1 : $result->name,
                'image' => $result->mainImage->thumb(327),
                'price' => number_format($result->price,0,'',' '),
            ];
            //exit();
            return $result;
        }
    }

    protected function findModel($slug)
    {
        if (($model = Product::findSlug($slug)) !== null) {
//            if(empty($model->seoTags->title)) {
//                \Yii::$app->view->title = $model->name;
//            }
//            if(empty($model->seoTags->description)) {
//                \Yii::$app->view->registerMetaTag([
//                    'name' => 'description',
//                    'content' => 'Купить '.$model->name.' за '.$model->price.' в интернет-магазине APFY.RU'
//                ]);
////                var_dump($model->seoTags->description);
////                exit;
//                //\Yii::$app->view->description = 'Купить '.$model->name.' за '.$model->price.' в интернет-магазине APFY.RU';
//            }
//            \Yii::$app->view->registerMetaTag([
//                'name' => 'description',
//                'content' => $model->description
//            ]);
//
//            \Yii::$app->view->registerMetaTag([
//                'name' => 'keywords',
//                'content' => $model->keywords
//            ]);
//
//

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findAttributeAll()
    {
        $model = ProductAttribute::find()->where(['user_id'=>\Yii::$app->params['user_id']])->all();
        if ($model !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
