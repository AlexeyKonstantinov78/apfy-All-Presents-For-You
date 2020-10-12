<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "maps".
 *
 * @property integer $id
 * @property string $adress
 * @property string $coords
 */
class Maps extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'maps';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adress', 'coords'], 'required'],
            [['adress'], 'string', 'max' => 128],
            [['coords'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'adress' => 'Adress',
            'coords' => 'Coords',
        ];
    }
}
