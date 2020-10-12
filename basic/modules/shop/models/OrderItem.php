<?php

namespace app\modules\shop\models;

use app\modules\shop\models\Product;
use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property integer $id
 * @property double $item_price
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $user_id
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_price', 'order_id', 'product_id'], 'required'],
            [['item_price'], 'number'],
            [['order_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */

    public function getProduct(){
        $query = $this->hasOne(Product::className(), ['id' => 'product_id'])->with(['seo']);
        return $query;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_price' => 'Item Price',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
        ];
    }
}
