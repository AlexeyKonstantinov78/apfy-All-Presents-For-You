<?php

namespace app\models;

use Yii;
use app\models\SeoTags;
use app\modules\shop\models\Product;
/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $parent_id
 * @property integer $sort
 * @property integer $active
 * @property boolean $is_brand
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
            [['name', 'description', 'sort'], 'required'],
            [['description', 'img'], 'string'],
            [['is_brand'], 'boolean'],
            [['parent_id', 'sort', 'active'], 'integer'],
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
            'parent_id' => 'Parent ID',
            'sort' => 'Сортировка',
            'active' => 'Показывать?',
            'is_brand' => 'Категория является брендом?',
        ];
    }

    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'id_product'])->viaTable('product_in_category',  ['id_category' => 'id']);
    }

    public static function findSlug($slug)
    {
        $model = seoTags::find()->where([
            'object' => 'Category',
            'slug' => $slug
        ])->one();
        if($model === null) return null;

        $cat = Category::find()->where(['category.id'=>$model->object_id])->one();
        if(empty($model->title)) $model->title = $cat->name;

        seoTags::registerMetaTag($model);

        $p = $cat->getParents()->all();

        if (!is_null($p)) {
            foreach($p as $cc) {
                \Yii::$app->params['breadcrumbs'][] = [
                    'label' => $cc->name,
                    'url' => ['/category/'.$cc->seoTags->slug],
                ];
            }
        }

        \Yii::$app->params['breadcrumbs'][] = [
            'label' => $cat->name,
        ];

        return $cat;
    }
}
