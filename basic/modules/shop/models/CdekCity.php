<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 26.03.2018
 * Time: 19:30
 */

namespace app\modules\shop\models;

use Yii;

class CdekCity extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'cdek_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name',  'cityName', 'regionName', 'center', 'cache_limit'], 'required'],
            //[['name',  'phone', 'email', 'town', 'street', 'house', 'apartment', 'delivery', 'delivery_choose'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Индификатор',
            'name' => 'Название',
            'cityName' => 'Название город',
            'regionName' => 'Регион',
            'center' => 'Центр',
            'cache_limit' => 'Кэш',
        ];
    }
}