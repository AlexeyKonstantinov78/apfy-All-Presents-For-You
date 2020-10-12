<?php

namespace app\models;

use Yii;
use app\models\SeoTags;
use app\models\Images;
use app\models\Articles;
use app\models\ArticleInCategory;
/**
 * This is the model class for table "article_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $parent_id
 * @property integer $sort
 * @property integer $active
 * @property integer $user_id
 */
class ArticleCategory extends \app\components\ArticleCategory
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['parent_id', 'sort', 'active'], 'integer'],
            [['name'], 'string', 'max' => 128],
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
            'description' => 'Описание',
            'parent_id' => 'Parent ID',
            'sort' => 'Sort',
            'active' => 'Отображать на странице? ',
        ];
    }

    /*
    public function getArticles()
    {
        return $this->hasMany(Articles::className(), ['id' => 'id_article'])->viaTable('article_in_category',  ['id_article_category' => 'id']);
    }

    public function getArticleInCat()
    {
        return $this->hasMany(ArticleInCategory::className(), ['id_article_category' => 'id']);
    }

    public function getArticles()
    {
        return $this->hasMany(Articles::className(), ['id' => 'id_article'])
            ->via('articleInCat');
    }
    //*/

    public static function findSlug($slug)
    {
        $model = seoTags::find()->where([
            'object' => substr(strrchr(self::className(), "\\"), 1),
            'slug' => $slug
        ])->one();
        if($model === null) return null;

        $cat = self::find()->with(['seo'])->where(['id'=>$model->object_id])->one();
        seoTags::registerMetaTag($model);

        \Yii::$app->params['breadcrumbs'][] = [
            'label' => $cat->name,
        ];

        return $cat;
    }



}
