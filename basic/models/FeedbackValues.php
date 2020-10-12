<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedback_values".
 *
 * @property integer $id
 * @property integer $feedback_id
 * @property string $field_value
 * @property integer $field_id
 */
class FeedbackValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['feedback_id', 'field_value', 'field_id'], 'required'],
            [['feedback_id', 'field_id'], 'integer'],
            [['field_value'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'feedback_id' => 'Feedback ID',
            'field_value' => 'Field Value',
            'field_id' => 'Field ID',
        ];
    }
}
