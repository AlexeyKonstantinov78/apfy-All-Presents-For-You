<?php

namespace app\modules\cabinet\models;

use Yii;

/**
 * This is the model class for table "wish_list".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $product_id
 */
class WishList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wish_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'product_id'], 'required'],
            [['id', 'user_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
        ];
    }
}
