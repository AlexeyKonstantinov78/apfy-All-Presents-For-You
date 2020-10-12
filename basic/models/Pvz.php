<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pvz".
 *
 * @property integer $id
 * @property string $country
 * @property string $region
 * @property string $town
 * @property string $name
 * @property string $street
 * @property string $house
 * @property string $office
 * @property string $comments
 * @property string $station
 * @property string $halt
 * @property string $phone
 * @property string $clock
 */
class Pvz extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pvz';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'country', 'region', 'town', 'name', 'street', 'house',
                    'office', 'comments', 'station', 'halt', 'phone', 'clock'
                ], 'required'
            ], [
                [
                    'country', 'region', 'town', 'name', 'street', 'house',
                    'office', 'comments', 'station', 'halt', 'phone', 'clock'
                ], 'string', 'max' => 512
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country' => 'Country',
            'region' => 'Region',
            'town' => 'Town',
            'name' => 'Name',
            'street' => 'Street',
            'house' => 'House',
            'office' => 'Office',
            'comments' => 'Comments',
            'station' => 'Station',
            'halt' => 'Halt',
            'phone' => 'Phone',
            'clock' => 'Clock',
        ];
    }
}
