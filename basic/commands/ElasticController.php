<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 10.12.2018
 * Time: 18:19
 */

namespace app\commands;

use yii\console\Controller;
use app\modules\shop\models\Product;
use app\modules\shop\models\Category;
use app\modules\shop\models\elastic\ElasticProduct;
use app\modules\shop\models\elastic\ElasticCategory;
use app\modules\shop\models\Filtres;

class ElasticController extends Controller
{
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
        //exit;
		
        //ElasticProduct::deleteAll();
        $elasticArray = [];
        $allProducts = Product::find()->with(['seo', 'imagess', 'categoryall'])->where(['>', 'active', 0])->asArray()->all();
		//$allProducts = Product::find()->with(['seo', 'imagess', 'categoryall'])->where(['active' => 1])->asArray()->all();
		//var_dump($allProducts); exit;
        $orderByNew = ['sort' => SORT_ASC,  'name' => SORT_ASC, ];
        ElasticProduct::deleteAll();
        //$allProducts = Product::find()->with([ 'categoryall'])->orderBy($orderByNew)->asArray()->all();
        foreach ($allProducts as $k=>$v){
            //var_dump($v['name']);
            //var_dump($v['seo']['slug']);
            if(count($v['categoryall'])<1) Continue;
            $cats = [];
            foreach ($v['categoryall'] as $key=>$val){
                $cats[] = (int)$val['id_category'];
            }
            $v['name'] = empty($v['seo']['h1']) ? $v['name'] : $v['seo']['h1'];
            //var_dump($v['mainimage']); exit;
            $elasticArray = [
                'name' => $v['name'],
                'artid' => $v['artid'],
                'slug' => $v['seo']['slug'],
                'product_id' => (int)$v['id'],
                'price' => (float)$v['price'],
                'discount_price' => (float)$v['discount_price'],
                'image' => $v['imagess']['image'],
                'sort' => (int)$v['sort'],
                'active' => (int)$v['active'],
                'cats' => $cats
            ];
            //var_dump($elasticArray); exit;
            $elasticAr[] = $elasticArray;
            //var_dump($elasticArray); exit;
            $model = new ElasticProduct();
            $model->attributes = $elasticArray;
            $model->save();
            //var_dump($model); exit;
            echo "Номер товара - " . $model->product_id . ". Название товара - " . $model->name ."\n";
            //echo "Название товара - "$model->name . "\n";
            //$el[] = $elasticArray['name'];

        }

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
        ElasticCategory::deleteAll();
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
            $product_quant = \app\components\Category::find()->select(['cnt' => 'sum(if(product.active = 0, 0, 1))', 'category.id'])->joinWith(['products'])->where(['category.id' => $v['id']])->asArray()->one();
            $filter = Filtres::getCategoriesIds($v['id']);
            $filters = array_merge([['id_category' => $v['id']]],$filter);
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
            $elasticAr[] = $elasticArray;
            $model = new ElasticCategory();
            $model->attributes = $elasticArray;
            $model->save();
            echo "Номер категории - " . $model->category_id . ". Название категории - " . $model->name ."\n";
        }
    }
}