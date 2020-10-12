<?php

namespace app\models;

use Yii;
use app\behaviors\SortableBehavior;
use app\models\BannerGroups;
/**
 * This is the model class for table "banner_elements".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $img
 * @property integer $sort
 * @property integer $parent_id
 * @property integer $user_id
 */
class BannerElements extends \yii\db\ActiveRecord
{
	#sorting
	public function behaviors() {
        return [
            [
                'class' => SortableBehavior::className(),
				'query' => function ($model) {
					$tableName = $model->tableName();
					return $model->find()->andWhere(["{$tableName}.[[parent_id]]" => $model->parent_id]);
				},
            ],
        ];
    }
    /**
     * @inheritdoc
     */
	
    public static function tableName()
    {
        return 'banner_elements';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parent_id'], 'required'],
            [['sort', 'parent_id'], 'integer'],
            [['name'], 'string', 'max' => 512],
            [['url', 'img'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Текст элемента',
            'url' => 'Ссылка на страницу (необязательно)',
            'img' => 'Картинку',
            'sort' => 'Сортировка',
            'parent_id' => 'Принадлежность к баннерам',
        ];
    }
	
	public function getGroupBanners($id){
		return BannerElements::find()->where(['parent_id' => $id])->all();
	}
	
	public function getBannersRegion($id){
		$model = BannerGroups::find()->where(['region_id' => $id])->one();
		if($model == null) return;
		return BannerElements::find()->where(['parent_id' => $model->id])->all();
	}
	
}
