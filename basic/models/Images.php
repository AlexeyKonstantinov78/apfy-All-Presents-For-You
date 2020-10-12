<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
use app\helpers\Image;
/**
 * This is the model class for table "images".
 *
 * @property integer $id
 * @property string $image
 * @property string $title
 * @property string $alt
 * @property string $object
 * @property integer $object_id
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['image', 'object', 'object_id'], 'required'],
            [['is_main', 'object_id'], 'integer'],
            [['image'], 'string', 'max' => 128],
            [['title', 'alt'], 'string', 'max' => 256],
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
            'image' => 'Картинка',
            'title' => 'Титл',
            'alt' => 'Альт',
            'is_main' => 'Основная фотография',
            'object' => 'Object',
            'object_id' => 'Object ID',
        ];
    }
	
	
	function thumb($width = null, $height = null, $crop = true)
    {
		return Image::thumb($this->image, $width, $height, $crop);
    }
	
	
	
	public function isEmpty()
    {
        return (!$this->image && !$this->object && !$this->object_id);
    }
	/*
	public static function getAllImages($object){
		return Images::find()->where(['object'=> substr(strrchr(get_class($object->owner), "\\"), 1), 'object_id'=>$object->id])->all();
	}
	
	public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'object_id']);
    }
	*/
}
