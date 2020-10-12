<?php

namespace app\models;

use Yii;
use app\models\SeoTags;
use app\behaviors\SeoBehavior;
/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 */
class Page extends \yii\db\ActiveRecord
{
	public $slug;
	
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['slug'], 'safe'],
            [['name'], 'required'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 256],
			[['template'], 'string', 'max' => 100], 
			[['is_main'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'text' => 'Текст',
			'template' => 'Шаблон'
			//'countryName' => 'Country Name',
        ];
    }
	public static function getMainpage(){
		return self::find()->where(['is_main' => '1'])->one();
	}

    public static function findSlug($slug)
    {
        if($slug == '')
        {
            $model = self::getMainpage();
            if($model == null) return null;
            seoTags::registerMetaTag($model->seoTags);

            return $model;
        }

        $model = seoTags::find()->where([
            'object' => 'Page',
            'slug' => $slug,
        ])->one();

        if($model === null) return null;

        $page = Page::find()->where(['id'=>$model->object_id])->one();
        seoTags::registerMetaTag($model);

        return $page;
    }
	
	public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
        ];
    }
	
	/*public function getSeo()
    {  
        return $this->hasOne(seoTags::className(), ['object_id' => 'id'])->where(['object' => 'Page']);
    }*/
}
