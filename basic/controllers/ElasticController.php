<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 21.11.2018
 * Time: 16:05
 */
namespace app\controllers;

use app\modules\shop\models\Category;
use app\modules\shop\models\Filtres;
use Yii;
use yii\web\Controller;
use app\modules\shop\models\Product;
use app\modules\shop\models\elastic\ElasticProduct;
use app\modules\shop\models\elastic\ElasticCategory;

class ElasticController extends Controller
{
    public function actionIndex(){
		/*
        $allProducts = Product::find()->with(['seo','imagess', 'categoryall'])->limit(20)->asArray()->all();
		ElasticProduct::deleteIndex();
		ElasticProduct::deleteIndexAll();
		//ElasticProduct::createIndex();
		foreach ($allProducts as $k=>$v){
            //var_dump($v['name']);
            //var_dump($v['seo']['slug']);
            if(count($v['categoryall'])<1) Continue;
            $cats = [];
            foreach ($v['categoryall'] as $key=>$val){
                $cats[] = (int)$val['id_category'];
            }

            //var_dump($v['mainimage']); exit;
            $elasticArray = [
                'name' => $v['name'],
                'slug' => $v['seo']['slug'],
                'product_id' => (int)$v['id'],
                'price' => (float)$v['price'],
                'discount_price' => (float)$v['discount_price'],
                'image' => $v['imagess']['image'],
                //'sort' => (int)$v['sort'],
                //'cats' => $cats
            ];
            $elasticAr[] = $elasticArray;
            //var_dump($elasticArray); exit;
			
			//var_dump($elasticArray); exit;
            $model = new ElasticProduct();
			
            $model->attributes = $elasticArray;
			//var_dump($model); exit;
            $model->save();
			//$model = ElasticProduct::find()->all();
			
            //var_dump($model); exit;
            echo "Номер товара - " . $model->product_id . ". Название товара - " . $model->name ."\n";
            //echo "Название товара - "$model->name . "\n";
            //$el[] = $elasticArray['name'];

        }
        
        //$model = ElasticProduct::find()->query($params)->limit(100)->all();
		*/
        $model = ElasticProduct::find()->all();
        //echo count($model).' - Это рузультат фильтрации:<br>';
        var_dump($model);
//        echo '<br><br><br><br>';
//        echo count($bigeningAr).'- изначальный массив до фильтров:<br>';
//        var_export($bigeningAr);
        //var_dump($model);
        exit;
    }

    public function actionCategory ($message = 'hello world') {
        echo $message . "\n";
        //exit;

        //ElasticProduct::deleteAll();
        $elasticArray = [];
        $elasticAr = [];
        $allCats = Category::find()->with(['seo', 'img'])->where(['>', 'active', 0])->asArray()->all();
        //var_dump($allCats); exit;
        //$allProducts = Product::find()->with(['seo', 'imagess', 'categoryall'])->where(['active' => 1])->asArray()->all();
        //var_dump($allProducts); exit;
        //$orderByNew = ['sort' => SORT_ASC,  'name' => SORT_ASC, ];
        //ElasticProduct::deleteAll();
        foreach($allCats as $k=>$v) {
            $v['name'] = empty($v['seo']['h1']) ? $v['name'] : $v['seo']['h1'];
            $query = Product::find()->joinWith(['category'])->where(['id_category'=>$v['id']])->andWhere(['>', 'active', 0])->orderBy(['active'=>SORT_ASC, 'id' => SORT_DESC]);
            $min = [
                'disc' => $query->min('discount_price'),
                'price' => $query->min('price')
            ];
            $priceMinMax = [
                'min' => (empty($min['disc']) || $min['disc']>$min['price']) ? floor($min['price']) : floor($min['disc']),
                'max' => floor($query->max('price')),
            ];
            $filter = Filtres::getCategoriesIds($v['id']);
            $filters = array_merge([['id_category' => $v['id']]],$filter);
            $product_quant = \app\components\Category::find()->select(['cnt' => 'sum(if(product.active = 0, 0, 1))', 'category.id'])->joinWith(['products'])->where(['category.id' => $v['id']])->asArray()->one();
            $product_quant = $product_quant['cnt'];
            $elasticArray = [
                'category_id' => (int)$v['id'],
                'parent_id' => (int)$v['parent_id'],
                'filter_category_id' => $filters,
                'filter_category_root' => (int)$v['id'],
                'seo_title' => $v['seo']['title'],
                'seo_description' => $v['seo']['description'],
                'seo_keywords' => $v['seo']['keywords'],
                'name' => $v['name'],
                'slug' => $v['seo']['slug'],
                'description' => $v['description'],
                'image' => $v['img']['image'],
                'sort' => (int)$v['sort'],
                'active' => (int)$v['active'],
                'is_brand' => (int)$v['is_brand'],
                'product_quant' => (int)$product_quant['cnt'],
                'max' => (int)$priceMinMax['max'],
                'min' => (int)$priceMinMax['min'],
                'tpl' => $v['tpl']
            ];
            //var_dump($elasticArray); exit;
            $elasticAr[] = $elasticArray;
            //var_dump($elasticArray); exit;
            $model = new ElasticCategory();
            $model->attributes = $elasticArray;
            $model->save();
            var_dump($model);
            exit;
        }
    }

}