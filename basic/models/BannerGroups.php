<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banner_groups".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $region_id
 * @property integer $user_id
 */
class BannerGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner_groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['slug'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название группы',
            'slug' => 'Отображение на страницах',
        ];
    }
}
