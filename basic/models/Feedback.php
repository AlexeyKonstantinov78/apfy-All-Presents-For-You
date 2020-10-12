<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedback".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $date
 * @property string $ip
 * @property string $user_agent
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'email', 'date', 'ip', 'user_agent'], 'required'],
            [['date'], 'safe'],
            [['name', 'email', 'user_agent'], 'string', 'max' => 64],
            [['phone'], 'string', 'max' => 12],
            [['ip'], 'string', 'max' => 32],
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
            'phone' => 'Phone',
            'email' => 'Email',
            'date' => 'Date',
            'ip' => 'Ip',
            'user_agent' => 'User Agent',
        ];
    }
}
