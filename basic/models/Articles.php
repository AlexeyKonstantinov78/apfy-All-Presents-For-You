<?php

namespace app\models;

use Yii;
use app\models\SeoTags;
use app\behaviors\SeoBehavior;
use app\models\Images;
use app\behaviors\ImageBehavior;
use app\models\ArticleCategory;
use app\models\ArticleInCategory;
/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $text
 * @property string $date
 * @property string $date_public
 * @property integer $user_id
 */
class Articles extends \yii\db\ActiveRecord
{
	//public $mainImage;
	
	public function behaviors()
    {
        return [
			'imageBehavior' => ImageBehavior::className(),
            'seoBehavior' => SeoBehavior::className(),
        ];
    }
    /** 
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text', 'date',], 'required'],
            [['text'], 'string'],
            [['date', 'date_public'], 'safe'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 256],
            [['description'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Загаловок',
            'description' => 'Краткое описание',
            'text' => 'Полное описание',
			'active' => 'Отображать статью?',
            'date' => 'Дата',
            'date_public' => 'Дата публикации',
        ];
    }
	
	/**
	* @more functions	
	*/
	public static function findSlug($slug)
	{
		$model = seoTags::find()->where([
                    'object' => substr(strrchr(self::className(), "\\"), 1),
                    'slug' => $slug,
                ])->one();
		if($model === null) return null;
		
		$cat = Articles::find()->with(['seo'])->where(['id'=>$model->object_id])->one(); 
		if(empty($model->title)) $model->title = $cat->name;
		seoTags::registerMetaTag($model);
		
		$c = ArticleCategory::find()->with(['seo'])->where(['id'=>$cat->articleincategory->id_article_category])->one();
		
		\Yii::$app->params['breadcrumbs'][] = [
            'label' => $c->name,
			'url' => ['/articles/'.$c->seoTags->slug],
		];
		
		\Yii::$app->params['breadcrumbs'][] = [
            'label' => $cat->name,
			
		];
		
		return $cat;
	}
	
	public function getSeo()
    {  
        return $this->hasOne(seoTags::className(), ['object_id' => 'id'])->where(['object' => substr(strrchr(get_class($this), "\\"), 1)]);
    }
	public function getArticleincategory()
	{
		return $this->hasOne(ArticleInCategory::className(), ['id_article' => 'id']);
	}
	public function getMain_image()
	{
		return $this->hasOne(Images::className(), ['object_id' => 'id'])->where(['object' => substr(strrchr(get_class($this), "\\"), 1)]);
	}

//*
    public function getArticlecategory()
    {
        return $this->hasOne(ArticleInCategory::className(), ['id_article' => 'id']);
    }

/*
    public function getArticles()
    {
        return $this->hasMany(Articles::className(), ['id' => 'id_article'])
            ->via('articleInCat');
    }
//*/
}
