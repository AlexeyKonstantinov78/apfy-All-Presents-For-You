<?php
namespace app\modules\shop\models;
use Yii;
use yii\db\Query;
use app\modules\shop\models\Product;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
//TODO
//Подумать над отдельной моделью
class ProductFiltres extends Product {
    public $id_category;

    public function rules() {
        return [
            [['id', 'name', 'id_category', 'price'], 'safe'],
        ];
    }

    public function filterNew($params) {
        $params['cats'] = array_diff($params['cats'], array(''));

        $query = Product::find()->select(['COUNT(*) AS cnt',
                'id' => 'product.id',
                'id_product' => 'product.id',
                'artid' => 'product.artid',
                'name' => 'product.name',
                'price' => 'product.price',])->joinWith(['category'])->with(['seo', 'imagess'])->groupBy('product.id')->andHaving(['cnt' => count($params['cats'])]);


        $query->andOnCondition([
            'id_category' => $params['cats'],
        ]);
        $result = $query->all();

        return $result;
    }

    public function filter($params) {
        $query = (new Query())
            ->select([
                'id' => 'product.id',
                'image' => 'images.image',
                'slug' => 'seo_tags.slug',
                'h1' => 'seo_tags.h1',
                'id_product' => 'product.id',
                'artid' => 'product.artid',
                //'id_int' => 'product.id_int',
                'name' => 'product.name',
                'price' => 'product.price',
                'discount_price' => 'product.discount_price',
                //'categories' => 'GROUP_CONCAT(category.name)'
            ])
            ->from('product')
            ->join('LEFT JOIN', 'product_in_category', 'product.id=product_in_category.id_product')
            ->join('LEFT JOIN', 'category', 'product_in_category.id_category=category.id')
            ->join('LEFT JOIN', 'images', 'images.object_id=product.id and images.object = \'Product\' and images.is_main=1')
            ->join('LEFT JOIN', 'seo_tags', 'seo_tags.object_id=product.id and seo_tags.object = \'Product\'')
            ->addGroupBy('product.id');
        foreach ($params['cats'] as $k=>$v){
            if($v == 0) Continue;
            $query->andFilterWhere(['product.id'=> (new Query())->select(['id_product'])->from('product_in_category')->where(['id_category' => $v]), 'product.active' => '1']);
        }
        //*/
        //$query->andFilterWhere(['product.id'=> (new Query())->select(['id_product'])->from('product_in_category')->where(['id_category' => '200'])]);
        //$query->andFilterWhere(['product.id'=> (new Query())->select(['id_product'])->from('product_in_category')->where(['id_category' => '204'])]);
        //$query->andFilterWhere(['product.id'=> (new Query())->select(['id_product'])->from('product_in_category')->where(['id_category' => '191'])]);
        //$query->andFilterWhere(['product.id'=> (new Query())->select(['id_product'])->from('product_in_category')->where(['id_category' => '373'])]);
        /*
        if($params['name'] == 'ASC'){
            $query->orderBy(['name' => SORT_ASC]);
        } elseif ($params['name'] == 'DESC'){
            $query->orderBy(['name' => SORT_ASC]);
        }
        if($params['price'] == 'ASC'){
            $query->orderBy(['price' => SORT_ASC]);
        } elseif ($params['price'] == 'DESC'){
            $query->orderBy(['price' => SORT_ASC]);
        }
        //$query->orFilterWhere(['product.id'=> (new Query())->select(['id_product'])->from('product_in_category')->where(['id_category' => '382'])]);
        /* подзапрос
        (new Query())->select(['id_product'])->from('product_in_category')->where(['id_category' => '200']);
        $subquery = (new Query())
            ->select([
                'id_product'
            ])
            ->from('product_in_category')
            ->where(['id_category' => '200']);
        $query->andFilterWhere(['product.id'=> $subquery]);
        //*/
        $sort = [];

        $sort1 = '';
        if($params['name'] == 'ASC') $sort['name'] = SORT_ASC;
        if($params['name'] == 'DESC') $sort['name'] = SORT_DESC;
        if($params['price'] == 'ASC') $sort['price'] = SORT_ASC;
        if($params['price'] == 'DESC') $sort['price'] = SORT_DESC;

        if($params['name'] == 'ASC') $sort1 = 'name ASC ';
        if($params['name'] == 'DESC') $sort1 = 'name DESC ';
        if($params['price'] == 'ASC') $sort1 = 'price ASC ';
        if($params['price'] == 'DESC') $sort1 = 'price DESC ';
        $sort['id'] = SORT_DESC;
//        var_dump($sort);
//        exit;
        $result = $query->orderBy($sort)->all();
        //*/
        return $result;
    }
    //*/


    /*
     * $query = 'SELECT id_product
            FROM product_in_category
            WHERE id_product IN (SELECT id_product FROM product_in_category WHERE id_category = 200)
              and id_product IN (SELECT id_product FROM product_in_category WHERE id_category = 204)
              and id_category = 191
            ';
     */


}