<?php

namespace app\modules\cabinet\models;

use Yii;

/**
 * This is the model class for table "tickets_chat".
 *
 * @property integer $id
 * @property integer $message
 * @property integer $parent_id
 * @property string $time
 */
class TicketsChat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tickets_chat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message', 'parent_id', 'time'], 'required'],
            [['message', 'parent_id'], 'integer'],
            [['time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'parent_id' => 'Parent ID',
            'time' => 'Time',
        ];
    }
}
