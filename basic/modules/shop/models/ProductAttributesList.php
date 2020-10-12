<?php

namespace app\modules\shop\models;

use Yii;

/**
 * This is the model class for table "product_attributes_list".
 *
 * @property integer $id
 * @property string $value
 * @property integer $product_id
 * @property integer $attr_id
 */
class ProductAttributesList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_attributes_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'product_id', 'attr_id'], 'required'],
            [['product_id', 'attr_id'], 'integer'],
            [['value'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Значение атрибута',
            'product_id' => 'Product ID',
            'attr_id' => 'Attr ID',
        ];
    }
	
	public function getProductAttribute(){
		return $this->hasOne(ProductAttribute::className(), ['id' => 'attr_id']);
	}
}
