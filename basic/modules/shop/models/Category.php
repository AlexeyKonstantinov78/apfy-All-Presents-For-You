<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 06.12.2016
 * Time: 0:22
 */
namespace app\modules\shop\models;

use Yii;
use app\models\SeoTags;

use app\models\Images;
use app\behaviors\ImageBehavior;
use app\modules\shop\models\Product;
use app\modules\shop\models\ProductInCategory;

//use app\components\Category;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $parent_id
 */
class Category extends \app\components\Category
{
    /**
     * @inheritdoc
     */


    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            //[['description', 'img'], 'string'],
            [['description',], 'string'],
            [[ 'small' ,], 'string', 'max' => 512],
            [['is_brand'], 'boolean'],
            [['parent_id', 'active'], 'integer'],
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
            'small' => 'Краткое описание',
            'tpl' => 'Шаблон категории', //после создание категорий сделать выбором
            //'img' => 'Изображение',
            'active' => 'Отображать на странице? ',
            'parent_id' => 'Parent ID',
            'is_brand' => 'Категория является брендом?',
        ];
    }

    /*
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'id_product'])->viaTable('product_in_category',  ['id_category' => 'id']);
    }
    //*/

    public static function findSlug($slug)
    {
        $model = seoTags::find()->where([
            'object' => 'Category',
            'slug' => $slug
        ])->one();
        if($model === null) return null;

        $cat = Category::find()->where(['category.id'=>$model->object_id, 'category.active' => 1])->one();
        if(empty($model->title)) {
            $model->title = $cat->name.' купить с доставкой по России.';
        };
        if(empty($model->description)) {
            $model->description = 'Купить '.$cat->name.' у официального дистрибьютера c доставкой по Москве и России вы можете в интернет-магазине APFY.RU, тел.: +74951991825';
        };

        seoTags::registerMetaTag($model, $cat);
        $p = $cat->getParents()->all();

        if (!is_null($p)) {
            foreach($p as $cc) {
                \Yii::$app->params['breadcrumbs'][] = [
                    'label' => empty($cc->seoTags->h1) ? $cc->name : $cc->seoTags->h1,
                    'url' => ['/category/'.$cc->seoTags->slug],
                ];
            }
        }

        \Yii::$app->params['breadcrumbs'][] = [
            'label' => empty($cat->seoTags->h1) ? $cat->name : $cat->seoTags->h1,
        ];

        return $cat;
    }
    /*public function getProducts(){
        return $this->hasMany(ProductInCategory::className(), ['id_category'=>'id']);
    }*/
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'id_product'])->viaTable('product_in_category',  ['id_category' => 'id']);
    }

    public function getLastCatsBrand(){
        return Category::find()->where(['is_brand'=>1])->all();
    }
    /*public function getImagesCategory()
    {
        $model = $this->hasOne(Images::className(), ['object_id' => 'id'])->where(['object' => substr(strrchr(get_class($this), "\\"), 1)]);
        return $model;
    }*/



}
