<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedback_fields".
 *
 * @property integer $id
 * @property string $field
 * @property string $pattern
 * @property integer $require_field
 */
class FeedbackFields extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback_fields';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field', 'require_field'], 'required'],
            [['require_field'], 'integer'],
            [['field'], 'string', 'max' => 128],
            [['pattern'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field' => 'Field',
            'pattern' => 'Pattern',
            'require_field' => 'Require Field',
        ];
    }
}
