<?php

namespace app\modules\shop\models; 

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\shop\models\Product;
/**
 * This is the model class for table "product_in_category".
 *
 * @property integer $id
 * @property integer $id_product
 * @property integer $id_category
 */
class ProductInCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_in_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_product', 'id_category'], 'required'],
            [['id_product', 'id_category'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_product' => 'Id Product',
            'id_category' => 'Id Category',
        ];
    }
	
	public static function setProductCategories($id_product, $data)
	{
		if(empty($data) || !is_array($data)) return false;
		$ids = self::getProductCategoriesIds($id_product);
		$ids = ArrayHelper::getColumn($ids, 'id_category');
		
		$new = array_diff($data,$ids);
		$delete = array_diff($ids,$data);
		if(!empty($delete))
			self::deleteAll(['id_category'=>$delete,'id_product'=>$id_product]);
		if(!empty($new))
		{
			foreach($new as $cat_id)
			{
				$model = new ProductInCategory();
				$model->id_product = $id_product;
				$model->id_category = $cat_id;
				$model->save();
			}
		}
	}
	
	public static function getProductCategoriesIds($id_product)
	{
		return self::find()->select('id_category')->where(['id_product'=>$id_product])->asArray()->all();
	}
	public static function getCategoryProperty($id_product, $property = null){
        return self::find()->select('id_category')->where(['id_product'=>$id_product, 'property' => $property])->asArray()->one();
    }

    public static function setCategoryProperty($id_product, $id_category, $property = 1){

        $oldModel  = self::find()->where(['id_product'=>$id_product, 'property' => 1])->one();

        if ($oldModel  !== null) {
            $oldModel->property = 0;
            $oldModel->save();
        }

        $model = self::find()->where(['id_product'=>$id_product, 'id_category' => $id_category])->one();

        if ($model == null){
            $model = new ProductInCategory();
            $model->id_product = $id_product;
            $model->id_category = $id_category;
        }
        $model->property = $property;
        return $model->save();
        //var_dump($model); exit;
    }

    public function getProduct(){
        return $this->hasOne(Product::className(), ['id' => 'id_product']);
    }
}
