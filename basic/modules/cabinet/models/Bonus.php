<?php

namespace app\modules\cabinet\models;

use Yii;

/**
 * This is the model class for table "bonus".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $order_id
 * @property string $message
 */
class Bonus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bonus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'message'], 'required'],
            [['user_id', 'order_id'], 'integer'],
            [['message'], 'string', 'max' => 128],
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
            'order_id' => 'Order ID',
            'message' => 'Message',
        ];
    }
}
