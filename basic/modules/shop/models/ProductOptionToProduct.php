<?php

namespace app\modules\shop\models;

use Yii;

/**
 * This is the model class for table "product_option_to_product".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $product_option_id
 * @property double $price
 */
class ProductOptionToProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_option_to_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'product_option_id', 'price'], 'required'],
            [['product_id', 'product_option_id'], 'integer'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'product_option_id' => 'Product Option ID',
            'price' => 'Price',
        ];
    }
}
