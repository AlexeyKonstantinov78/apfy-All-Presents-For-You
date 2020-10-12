<?php

namespace app\modules\root\models;

use Yii;

/**
 * This is the model class for table "rss".
 *
 * @property integer $id
 * @property string $name
 * @property string $mail
 * @property string $message
 * @property string $object
 * @property integer $object_id
 */
class Rss extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rss';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'mail', 'message', 'object'], 'required'],
            [['object_id'], 'integer'],
            [['name', 'mail', 'message'], 'string', 'max' => 128],
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
            'name' => 'Name',
            'mail' => 'Mail',
            'message' => 'Message',
            'object' => 'Object',
            'object_id' => 'Object ID',
        ];
    }
}
