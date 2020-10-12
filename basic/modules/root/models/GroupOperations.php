<?php
namespace app\modules\root\models;
use Yii;
use app\modules\shop\models\ProductInCategory;

class GroupOperations {
	public static function changeCategoriesProducts($products, $cat){
		ProductInCategory::deleteAll(['in', 'id_product', $products]);
		foreach($products as $k => $v){		
			ProductInCategory::setProductCategories($v,$cat);
		}
	}
}
?>