<?php

namespace app\modules\cabinet\models;

use Yii;

/**
 * This is the model class for table "tickets".
 *
 * @property integer $id
 * @property string $title
 * @property string $message
 * @property integer $status
 * @property integer $user_id
 * @property string $date
 */
class Tickets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tickets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'message', 'status', 'user_id', 'date'], 'required'],
            [['status', 'user_id'], 'integer'],
            [['date'], 'safe'],
            [['title'], 'string', 'max' => 64],
            [['message'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'message' => 'Message',
            'status' => 'Status',
            'user_id' => 'User ID',
            'date' => 'Date',
        ];
    }
}
