<?php
namespace app\modules\root\models;
use Yii;
use yii\db\Query;
use app\modules\root\models\Product;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

class ProductSearch extends Product {
	public $id_category;
	
	public function rules() {
        return [
            [['id', 'name', 'id_int', 'artid', 'id_category', 'price', 'discount_price'], 'safe'],
        ];
    } 
	
	public function search($params) {
						
		$query = (new Query())
        ->select([
			'id' => 'product.id',
			'image' => 'images.image',
            'id_product' => 'product.id',
            'active' => 'product.active',
			'artid' => 'product.artid',
            'id_int' => 'product.id_int',
            'name' => 'product.name',
			'price' => 'product.price',
			'discount_price' => 'product.discount_price',
            'categories' => 'GROUP_CONCAT(category.name)'
        ])
        ->from('product')
        ->join('LEFT JOIN', 'product_in_category', 'product.id=product_in_category.id_product')
        ->join('LEFT JOIN', 'category', 'product_in_category.id_category=category.id')
        ->join('LEFT JOIN', 'images', 'images.object_id=product.id and images.object = \'Product\' and images.is_main=1')
		->addGroupBy('product.id');

		if(isset($this->id_category[0]))
		if($this->id_category[0] == '-1') $this->id_category = null;

    // Adds additional WHERE conditions to the existing query but ignores empty operands
		$query->andFilterWhere(['like', 'product.name', $this->name])
          ->andFilterWhere(['like', 'product.id_int', $this->id_int])
          ->andFilterWhere(['like', 'product.artid', $this->artid]);
		  if(isset($this->id_category[0]))
		  if($this->id_category[0] == '-2') 
			$query->andFilterWhere(['is', 'category.id', new Expression('NULL')]);
		  else
			$query->andFilterWhere(['in', 'product_in_category.id_category', $this->id_category]);
			
		  $query
		  ->andFilterWhere(['=', 'product.price', $this->price]);
        $query->andFilterWhere(['=', 'product.active', $this->active]);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => ['attributes' => ['id', 'id_product', 'artid', 'id_int', 'name', 'price', 'discount_price', 'active']]
        ]);
 
        return $dataProvider;
    }
	
	
	
}