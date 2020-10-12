<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "article_in_category".
 *
 * @property integer $id
 * @property integer $id_article
 * @property integer $id_article_category
 * @property integer $user_id
 */
class ArticleInCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_in_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_article', 'id_article_category'], 'required'],
            [['id_article', 'id_article_category'], 'integer'],
            [['id_article', 'id_article_category'], 'unique', 'targetAttribute' => ['id_article', 'id_article_category'], 'message' => 'Привет.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_article' => 'Id Article',
            'id_article_category' => 'Id Article Category',
        ];
    }
	
	public static function setArticleCategories($id_article, $data)
	{
		if(empty($data) || !is_array($data)) return false;
		$ids = self::getArticleCategoriesIds($id_article);
		$ids = ArrayHelper::getColumn($ids, 'id_article_category');
		
		$new = array_diff($data,$ids);
		$delete = array_diff($ids,$data);
		if(!empty($delete))
			self::deleteAll(['id_article_category'=>$delete,'id_article'=>$id_article]);
		if(!empty($new))
		{
			foreach($new as $cat_id)
			{
				$model = new ArticleInCategory();
				$model->id_article = $id_article;
				$model->id_article_category = $cat_id;
				$model->save();
			}
		}
	}
	
	public static function getArticleCategoriesIds($id_article)
	{
		return self::find()->select('id_article_category')->where(['id_article'=>$id_article])->asArray()->all();
	}
}
