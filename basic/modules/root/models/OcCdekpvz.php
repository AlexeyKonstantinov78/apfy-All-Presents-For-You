<?php

namespace app\modules\root\models;

use Yii;

/**
 * This is the model class for table "oc_cdekpvz".
 *
 * @property integer $id
 * @property string $name
 * @property string $region
 * @property string $region_code
 * @property string $address
 * @property string $full_address
 * @property string $work_time
 * @property string $phone
 * @property string $town
 * @property string $city_code
 * @property string $address_comment
 * @property string $email
 * @property string $nearest_station
 * @property string $metro_station
 * @property string $country
 * @property string $code
 * @property string $postal_code
 * @property string $country_code_iso
 * @property string $path
 */
class OcCdekpvz extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oc_cdekpvz';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'name', 'region', 'town', 'address',
                ], 'required'
            ], [
                [
                    'name', 'region', 'address', 'work_time', 'phone', 'town',
                    'nearest_station', 'metro_station', 'country'
                ], 'string', 'max' => 512
            ], [
                [
                    'region_code', 'city_code', 'code', 'postal_code',
                    'country_code_iso'
                ], 'string', 'max' => 64
            ], [
                ['full_address', 'address_comment', 'path'], 'string',
                'max' => 1024
            ], [['email'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID', 'name' => 'Name', 'region' => 'Region',
            'region_code' => 'Region Code', 'address' => 'Address',
            'full_address' => 'Full Address', 'work_time' => 'Work Time',
            'phone' => 'Phone', 'town' => 'Town', 'city_code' => 'City Code',
            'address_comment' => 'Address Comment', 'email' => 'Email',
            'nearest_station' => 'Nearest Station',
            'metro_station' => 'Metro Station', 'country' => 'Country',
            'code' => 'Code', 'postal_code' => 'Postal Code',
            'country_code_iso' => 'Country Code Iso', 'path' => 'Path',
        ];
    }
}
