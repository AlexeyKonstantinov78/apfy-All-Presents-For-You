<?php

namespace app\modules\shop\controllers;

use Yii;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\shop\models\ProductFiltres;
use app\modules\shop\models\Category;
use app\modules\shop\models\Product;
use app\modules\shop\models\Filtres;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
        $tree = Category::generateTree();
		return $this->render('index', [
            'tree' => $tree,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionAjax()
    {
        //if (Yii::$app->request->isAjax and Yii::$app->request->get()){
        if (Yii::$app->request->get()){

            $products = ProductFiltres::filter(Yii::$app->request->get());
            return $this->renderAjax('list_products', [
                'products' => $products,
            ]);
 
            //$products = ProductFiltres::filterNew(Yii::$app->request->get());
            //return $this->renderAjax('list_product_new', [
            //    'products' => $products,
            //]);
        }
    }
    public function actionView($slug)
    {

		$model = $this->findModel($slug);

        $query = Product::find()->joinWith(['category'])->where(['id_category'=>$model->id])->andWhere(['>', 'active', 0])->orderBy(['active'=>SORT_ASC, 'id' => SORT_DESC]);
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize'=>12]);
		$products = $query->offset($pages->offset)->limit($pages->limit)->all();
		//TODO

		$filtres = Filtres::getCategoriesIds($model->id);
        $filtres = array_merge([['id_category' => $model->id]],$filtres);
        $min = [
            'disc' => $query->min('discount_price'),
            'price' => $query->min('price')
        ];
        $priceMinMax = [
            'min' => (empty($min['disc']) || $min['disc']>$min['price']) ? floor($min['price']) : floor($min['disc']),
            'max' => floor($query->max('price')),
        ];
        /**/
        if(isset($_GET['deb']))
            $template = 'view_aside';
        else
            $template = 'view';
        //*/
        return $this->render($template, [
            'model' => $model,
			'products' => $products,
			'pages' => $pages,
            'filters' => $filtres,
            'priceMinMax' => $priceMinMax
        ]);
    }

    protected function findModel($slug)
    {
        if (($model = Category::findSlug($slug)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //подгрузка товаров по фильтрам, надо Выбрать
    protected function AjaxFilterEx(){
        //$query = 'SELECT t1.`id_product`, t2.`id_product`, t3.`id_product` FROM `product_in_category` t1, `product_in_category` t2, `product_in_category` t3 WHERE t1.`id_category`=191 AND t2.`id_category`=352 AND t1.`id_product`=t2.`id_product` AND t3.`id_category`=353 AND t1.`id_product`=t3.`id_product`';
        //$query = 'SELECT * FROM `product_in_category`'; //test
        $query = 'select a.id, a.id_product from product_in_category a
            where 
            id_category = 191
            and
            EXISTS (
               SELECT id_category, id_product
               FROM product_in_category
               WHERE id_category = 352 and a.id_product=id_product
            ) 
            and
            EXISTS (
               SELECT id_category, id_product
               FROM product_in_category 
               WHERE id_category = 353 and a.id_product=id_product
            )
            ';
        $result = Yii::$app->db
            ->createCommand($query)
            ->queryAll();
        return $result;
    } //0.0 ms exists

    protected function AjaxFilterIn(){
        //$query = 'SELECT t1.`id_product`, t2.`id_product`, t3.`id_product` FROM `product_in_category` t1, `product_in_category` t2, `product_in_category` t3 WHERE t1.`id_category`=191 AND t2.`id_category`=352 AND t1.`id_product`=t2.`id_product` AND t3.`id_category`=353 AND t1.`id_product`=t3.`id_product`';
        //$query = 'SELECT * FROM `product_in_category`'; //test
        $query = 'SELECT id_product
            FROM product_in_category
            WHERE id_product IN (SELECT id_product FROM product_in_category WHERE id_category = 352)
              and id_product IN (SELECT id_product FROM product_in_category WHERE id_category = 353)
              and id_category = 191
            ';
        $result = Yii::$app->db
            ->createCommand($query)
            ->queryAll();
        return $result;
    } //0.1 ms IN

    protected function AjaxFilterLJ(){
        //$query = 'SELECT t1.`id_product`, t2.`id_product`, t3.`id_product` FROM `product_in_category` t1, `product_in_category` t2, `product_in_category` t3 WHERE t1.`id_category`=191 AND t2.`id_category`=352 AND t1.`id_product`=t2.`id_product` AND t3.`id_category`=353 AND t1.`id_product`=t3.`id_product`';
        //$query = 'SELECT * FROM `product_in_category`'; //test
        $query = 'SELECT a.id_product
            FROM product_in_category a
            LEFT JOIN product_in_category b ON a.id_product=b.id_product 
            LEFT JOIN product_in_category c ON a.id_product=c.id_product 
            WHERE 
            a.id_category = 191
            and b.id_category = 352
            and c.id_category = 353
            ';
        $result = Yii::$app->db
            ->createCommand($query)
            ->queryAll();
        return $result;
    } //0.1 ms left join

}
