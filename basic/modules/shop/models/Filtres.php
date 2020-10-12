<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 24.10.2017
 * Time: 10:57
 */

namespace app\modules\shop\models;
use Yii;
use yii\helpers\ArrayHelper;

class Filtres extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'filtres';
    }
    public function rules()
    {
        return [
            [['root_category', 'id_category'], 'required'],
            [['root_category', 'id_category'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'root_category' => 'Родительская категория',
            'id_category' => 'Вложенные категории',
        ];
    }

    public static function setFiltresCategories($root_category, $data)
    {

        if(empty($data) || !is_array($data)) return false;
        $ids = self::getCategoriesIds($root_category);
        $ids = ArrayHelper::getColumn($ids, 'id_category');
        $new = array_diff($data,$ids);
        $delete = array_diff($ids,$data);
        if(!empty($delete))
            self::deleteAll(['root_category'=>$root_category,'id_category'=>$delete]);
        if(!empty($new))
        {
            foreach($new as $cat_id)
            {
                $model = new Filtres();
                $model->root_category= $root_category;
                $model->id_category = $cat_id;
                $model->save();
            }
        }
    }
    public static function getCategoriesIds($root_category)
    {
        return self::find()->select('id_category')->where(['root_category'=>$root_category])->asArray()->all();
    }
}