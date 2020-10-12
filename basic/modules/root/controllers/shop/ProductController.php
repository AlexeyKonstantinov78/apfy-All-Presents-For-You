<?php

namespace app\modules\root\controllers\shop;
use Yii;
use app\modules\shop\models\Product;
use app\modules\shop\models\Category;
use app\models\Images;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;
use app\modules\root\models\GroupOperations;
use app\modules\root\models\ProductSearch;
use app\modules\root\controllers\DefaultController;
use app\modules\shop\models\ProductAttributesList; 
use app\modules\shop\models\ProductAttribute;
use app\modules\shop\models\ProductInCategory; 


use yii\helpers\ArrayHelper;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends DefaultController
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
    /*
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**/
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $searchModel->load(Yii::$app->request->get());
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=30;
        $model = new Category();

        $tree = $model->generateTreeJs();
        //var_dump($tree);
        //exit();
        /*Потом допилить и проверить
       if(isset(Yii::$app->request->post()['submit-button'])){
           GroupOperations::changeCategoriesProducts(Yii::$app->request->post()['productsCheck'], Yii::$app->request->post()['ft_1']);

           //ProductInCategory::deleteAll('id_product = :id', [':id' => Yii::$app->request->post()['productsCheck']]);
           if(isset(Yii::$app->request->post()['ft_1'])){
               foreach(Yii::$app->request->post()['productsCheck'] as $k => $v){
                   //ProductInCategory::deleteAll('id_product = :id', [':id' => $id]);
                   //ProductInCategory::setProductCategories($model->id,Yii::$app->request->post()['ft_1']);
                   echo '<br>товарчик'.$v;
               }
               var_dump(Yii::$app->request->post());
               exit();
           }
           //* /
        }
        //*/
        //Yii::$app->request->post()
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'tree' => $tree,
            'searchModel' => $searchModel
        ]);
    }
    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $now_date = date('Y-m-d H:i:s');
        $model = new Product(['active'=>'1', 'weight'=>0.1, 'scope'=>90, 'date'=>$now_date, ]);
		$attributes = $this->findAttributeAll();
		$category = new Category();
		$allCats = $category->generateTreeEditCat();
		$tree = $category->generateTreeJs(['expanded'=>'all']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if(isset(Yii::$app->request->post()['ft_1'])){
				ProductInCategory::setProductCategories($model->id,Yii::$app->request->post()['ft_1']);
			}
			if(!empty(Yii::$app->request->post()['mainCategory']) && Yii::$app->request->post()['mainCategory'] !== 'prompt'){
                ProductInCategory::setCategoryProperty($model->id,Yii::$app->request->post('mainCategory'), 1);
            }
			if(array_key_exists('ProductAttributesList', Yii::$app->request->post())){
				foreach(Yii::$app->request->post()['ProductAttributesList'] as $k) {
					if(array_key_exists('attr_id', $k)){
						$this->AddAtribute($k, $model->id);
					}
				}
			}
            return $this->redirect(['index']);
        } else {
			//exit();
            return $this->render('create', [
                'model' => $model,
				'model_images' => $model->images,
				'attributes' => $attributes,
				'tree' => $tree,
                'allCats' => $allCats,
				//'model_main_image' => $model->mainImage,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		
		
		
		$model = $this->findModel($id);
		
		//$images = Images::getAllImages($model);
		/*
		var_dump($model->mainImage);
		exit;
		//*/
		$attributes = $this->findAttributeAll();
		
		$category = new Category();
		$allCats = $category->generateTreeEditCat();
		$ids = ProductInCategory::getProductCategoriesIds($id);
		$ids = ArrayHelper::getColumn($ids, 'id_category');
		
		$options = ['expanded'=>'all'];
		foreach($ids as $v)
			$options[$v] = ['selected'=>true];
		
		$tree = $category->generateTreeJs($options);
        //$now_date = date('Y-m-d H:i:s');
		if ($model->load(Yii::$app->request->post()) && $model->save()){// && $model->save()){ //&& Model::validateMultiple($model)
			
			if(isset(Yii::$app->request->post()['ft_1'])){
				ProductInCategory::setProductCategories($id,Yii::$app->request->post()['ft_1']);
			}
			if(!empty(Yii::$app->request->post()['mainCategory']) && Yii::$app->request->post()['mainCategory'] !== 'prompt'){
                ProductInCategory::setCategoryProperty($model->id,Yii::$app->request->post('mainCategory'), 1);
            }
			$modelattrs = $model->productAttributesList;
			if(Model::loadMultiple($modelattrs, Yii::$app->request->post()) && Model::validateMultiple($modelattrs)){
				foreach ($modelattrs as $modelattr) {
					$modelattr->save(false);	
				}
			}
			
			if(array_key_exists('ProductAttributesList', Yii::$app->request->post())){
				foreach(Yii::$app->request->post()['ProductAttributesList'] as $k) {
					if(array_key_exists('attr_id', $k)){
						$this->AddAtribute($k, $id);
					}
				}
			}
			
			//exit;
			return $this->redirect('index');
            
		} else {
			//var_dump($model->mainImage);
			//exit();
            return $this->render('update', [
                'model' => $model,
				'model_images' => $model->images,
				'model_main_image' => $model->img,
				'attributes' => $attributes,
				'tree' => $tree,
				'allCats' => $allCats,
				'mainCats' => ProductInCategory::getCategoryProperty($id, 1),
            ]);
        }
		
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		ProductInCategory::deleteAll('id_product = :id', [':id' => $id]);
        return $this->redirect(['index']);
    }
	
	public function actionDelattributelist(){
		if(Yii::$app->request->isAjax){
			$p = Yii::$app->request->post();
			ProductAttributesList::find()->where(['id' => $p['id']])->one()->delete();
			return true;
		}
		return false;
	}

	/**
     * ajax item from cat id
     */
    public function actionGetitem($id) {
        //SELECT * FROM product as p LEFT JOIN product_in_category as c ON p.id = c.id_product WHERE c.id_category=200
        $query = Product::find()->joinWith(['category'])->where(['id_category'=>$id])->orderBy('sort desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        return $this->renderAjax('list_product', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
		$model = Product::find()->where(['id'=>$id])->one();
        if ($model  !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findAttributeAll()
    {
        if (($model = ProductAttribute::find()->all()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function AddAtribute($post, $product_id){
		$attr = new ProductAttributesList();
		$attr->value = $post['value'];
		$attr->product_id = $product_id;
		$attr->attr_id = $post['attr_id'];
		if ($attr->save()){
			return true;
		} 
		return false;			
	}

	protected  function findModelFromCatId($id){

    }
	
	/*
     * Поиск категорий
     */
    public function actionCategory_find(){

        //Yii::$app->response->format = Response::FORMAT_JSON;
        if(Yii::$app->request->isAjax) {
            $query = Yii::$app->request->post('query');
            $likedata[] = ['like', 'name', $query];
            $qmodels = Category::find()->with('seo')->where(array_merge( ['or'],$likedata))->asArray()->all();

            return $this->renderAjax('list_cats', [
                'cats' => $qmodels,
            ]);
        }
    }
}
