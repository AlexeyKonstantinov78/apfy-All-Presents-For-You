<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 28.05.2019
 * Time: 11:48
 */

namespace app\modules\root\models;

use Yii;
use app\models\SeoTags;
use app\behaviors\SeoBehavior;
use app\models\Images;
use app\behaviors\ImageBehavior;

class Product extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'product';
    }

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

    public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
            'imageBehavior' => ImageBehavior::className(),
        ];
    }

    public function getShelf()
    {
        return $this->hasOne(Shelf::className(), ['product_id' => 'id']);
    }
}