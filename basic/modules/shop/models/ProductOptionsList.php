<?php

namespace app\modules\shop\models;

use Yii;

/**
 * This is the model class for table "product_options_list".
 *
 * @property integer $id
 * @property integer $option_id
 * @property string $name
 * @property double $price
 * @property integer $position
 * @property string $object
 * @property integer $object_id
 */
class ProductOptionsList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_options_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['option_id', 'name', 'price', 'position', 'object', 'object_id'], 'required'],
            [['option_id', 'position', 'object_id'], 'integer'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 128],
            [['object'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'option_id' => 'Option ID',
            'name' => 'Name',
            'price' => 'Price',
            'position' => 'Position',
            'object' => 'Object',
            'object_id' => 'Object ID',
        ];
    }
}
