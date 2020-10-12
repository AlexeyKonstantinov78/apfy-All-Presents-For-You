<?php

namespace app\modules\shop\models;

use Yii;
/**
 * This is the model class for table "product_option".
 *
 * @property integer $id
 * @property double $price
 * @property string $type
 * @property integer $sort
 * @property integer $product_option_id
 */
class ProductOption extends \app\components\Category
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'type', 'sort', 'product_option_id'], 'required'],
            [['price'], 'number'],
            [['sort', 'product_option_id'], 'integer'],
            [['type'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Цена',
            'type' => 'Тип',
            'sort' => 'Sort',
            'product_option_id' => 'Product Option ID',
        ];
    }
}
