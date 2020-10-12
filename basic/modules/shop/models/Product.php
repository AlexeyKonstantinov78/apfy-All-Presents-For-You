<?php

namespace app\modules\shop\models;

use Yii;
use app\models\SeoTags;
use app\behaviors\SeoBehavior;
use app\models\Images;
use app\behaviors\ImageBehavior;
use app\modules\shop\models\ProductAttributesList; 
use app\modules\shop\models\ProductAttribute;
use app\modules\shop\models\ProductInCategory; 
use app\modules\shop\models\Category;
use app\models\OrderItem;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property double $price
 * @property double $discount_price
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	//public $seo;
	//public $images;
	
    public static function tableName()
    {
        return 'product';
    }
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			//[['images',], 'safe'],
            [['date'], 'safe'],
            [['name', 'description', 'price', 'weight', 'scope'], 'required'],
            [['description',], 'string'],
            [['price', 'discount_price', 'weight', 'scope'], 'number'],
            [['sort'], 'integer', 'max' => 12],
            [['active'], 'integer', 'max' => 2],
            [['artid', 'gtin'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'artid' => 'Артикул',
            'gtin' => 'GTIN',
            'price' => 'Цена',
            'scope' => 'Объем',
            'weight' => 'Вес',
            'discount_price' => 'Скидочная цена',
            'sort' => 'Сортировка',
            'active' => 'Отображание товара',
            'date' => 'Последняя дата обновление',
        ];
    }
/*
    public function getAttributeLabel()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'artid' => 'Артикул',
            'price' => 'Цена',
            'discount_price' => 'Скидочная цена',
            'sort' => 'Сортировка',
            'active' => 'Отображание товара',
        ];
    }
*/
	public function behaviors()
    {
        return [
			'seoBehavior' => SeoBehavior::className(),
			'imageBehavior' => ImageBehavior::className(),
        ];
    }
	
	public function getProductAttributesList(){
		return $this->hasMany(ProductAttributesList::className(), ['product_id' => 'id'])->with(['productAttribute'])->orderBy('id')->all();
	}
	
	public function getOrderitem(){
        return $this->hasOne(OrderItem::className(),['product_id'=>'id']);
    }
		
	public function getCategory()
	{
		return $this->hasOne(ProductInCategory::className(), ['id_product' => 'id']);
	}
/*	
	public function getCategories()
	{
		return $this->hasOne(Category::className(), ['id' => 'id_category'])->viaTable(ProductInCategory::tableName(), ['id_product'=>'id']);
	}
*/

    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'id_category'])->viaTable(ProductInCategory::tableName(), ['id_product'=>'id']);
    }

	
	public function getCategoryall()
	{

		return $this->hasMany(ProductInCategory::className(), ['id_product' => 'id']);
	}
	
    /*public function getBrand($id)
    {
        return Category::find()->joinWith('products')->where(['id_product' => 467, 'is_brand' => 1])->one();
        //$this->hasOne(Category::className(), ['id' => 'id_category'])->viaTable(ProductInCategory::tableName(), ['id_product'=>'id', 'is_brand'=>1]);
    }*/

	public static function findSlug($slug)
	{

		$model = seoTags::find()->where([
                    'object' => 'Product',
                    'slug' => $slug
                ])->one();
		if($model === null) return null;
        //вывод категорий


        $url = \yii::$app->request->referrer;
        $url = explode('?', $url);
        $ref = explode('/', $url[0]);
        $cat = Product::find()->with(['seo', 'categories'])->where(['id'=>$model->object_id])->one();
        $c = Category::findSlug($ref[count($ref)-1]);
        if((count($ref)>0 || $ref[count($ref)-2] == 'category') && !is_null($c)) {

                //p = $c->getParents()->all();
                $b = \Yii::$app->params['breadcrumbs'];
                unset(\Yii::$app->params['breadcrumbs'][count($b)-1]);
                \Yii::$app->params['breadcrumbs'][] = [
                    'label' => empty($c->seoTags->h1) ? $c->name : $c->seoTags->h1,
                    'url' => ['/category/'.$c->seoTags->slug],
                ];

        } else {
			//* заменить на это
			if($cat->category == null) $catIdMain = '';
            else {
                $catIdMain = ProductInCategory::getCategoryProperty($cat->id, 1);
                //var_dump($catIdMain); exit;
                if($catIdMain !== null)
                    $catIdMain = $catIdMain['id_category'];
                else
                    $catIdMain = $cat->category->id_category;
            }
            $c = Category::find()->with(['seo'])->where(['id'=>$catIdMain])->one();
            if(!is_null($c))
                $p = $c->getParents()->all();
            else
                $p = null;
            if (!is_null($p)) {
                foreach($p as $cc) {
                    \Yii::$app->params['breadcrumbs'][] = [
                        'label' => $cc->name,
                        'url' => ['/category/'.$cc->seoTags->slug],
                    ];
                }
            }
			
			//*/
			/*
            //получение товаров
            //получение всех последних категорий брэндов
            $lastCatBrands = Yii::$app->cache->get('lastCatBrands');
            //$lastCatBrands = false;
            if ($lastCatBrands === false) {
                $lastCatBrands = self::getCatsBrands();
                Yii::$app->cache->set('lastCatBrands', $lastCatBrands, 10000);
            }
            //var_dump($lastCatBrands);



            //ищем конечную категорию
            $lastCat = '';
            foreach ($cat->categories as $k=>$v){
                if(in_array($v->name, $lastCatBrands)){
                    $lastCat['id'] = $v->id;
                    $lastCat['slug'] = $v->seoTags->slug;
                    $lastCat['name'] = empty($v->seoTags->h1) ? $v->name : $v->seoTags->h1;
                    Break;
                }
            }
            if(!empty($lastCat)){
                //находим дерево категорий
                $breadCats = Category::find()->where(['category.id'=>$lastCat['id'], 'category.active' => 1])->one();
                $breadCats = $breadCats->getParents()->all();
                foreach ($breadCats as $k=>$v){
                    \Yii::$app->params['breadcrumbs'][] = [
                        'label' => empty($v->seoTags->h1) ? $v->name : $v->seoTags->h1,
                        'url' => ['/category/'.$v->seoTags->slug],
                    ];
                }
                \Yii::$app->params['breadcrumbs'][] = [
                    'label' => $lastCat['name'],
                    'url' => '/category/'.$lastCat['slug']
                ];
            }
			//*/

        }

        \Yii::$app->params['breadcrumbs'][] = [
            'label' => empty($cat->seoTags->h1) ? $cat->name : $cat->seoTags->h1
        ];
        //var_dump($lastCat);
        //exit;
        /*
         * Старая модель
         */
//        $url = \yii::$app->request->referrer;
//        $url = explode('?', $url);
//        $ref = explode('/', $url[0]);
//        if(count($ref)>0 || $ref[count($ref)-2] == 'category') {
//            $c = Category::findSlug($ref[count($ref)-1]);
//            if(!is_null($c)){
//                //p = $c->getParents()->all();
//                $b = \Yii::$app->params['breadcrumbs'];
//                unset(\Yii::$app->params['breadcrumbs'][count($b)-1]);
//                \Yii::$app->params['breadcrumbs'][] = [
//                    'label' => empty($c->seoTags->h1) ? $c->name : $c->seoTags->h1,
//                    'url' => ['/category/'.$c->seoTags->slug],
//                ];
//            }
//
//        }
//        \Yii::$app->params['breadcrumbs'][] = [
//            'label' => $cat->name,
//
//        ];
        /*
         * конец старому
        */





		seoTags::registerMetaTag($model, $cat);
		
		return $cat;
	}


    /*
    public function getMainimage()
    {
        return $this->hasOne(Images::className(), ['object_id' => 'id'])->andOnCondition(['is_main'=>1]);
    }
    //*/
	//*
	public function getImagess()
    {
        return $this->hasOne(Images::className(), ['object_id' => 'id'])->andOnCondition(['is_main'=>1]);
    }
	//*/
    private function getCatsBrands(){
        $category = new Category();
        $brands = $category->getLastCatsBrand();
        $lastCatBrands = [];
        foreach ($brands as $k=>$v){
            $lastCatBrands = $lastCatBrands+$category->getLastChild($v->children);
        }
        return $lastCatBrands;
    }

    public function getBrandProduct($id=null){
        $category = new Category();
        $brands = Yii::$app->cache->get('brands');
        if ($brands === false) {
            $brands = $category->getLastCatsBrand();
            $brands = ArrayHelper::toArray($brands, [
                'app\modules\shop\models\Category' => [
                    'id',
                    'name'
                ]
            ]);
            Yii::$app->cache->set('brands', $brands, 10);
        }

        foreach ($this->categories as $k=>$v){
            foreach ($brands as $k1=>$v1) {
                if($v->id == $v1['id']) return $v1['name'];
            }
        }
	    return 'ошибка';
    }
}
