<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 14.03.2018
 * Time: 19:50
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use app\modules\shop\models\Category;

class SitemapgeneratorController extends Controller
{
    public function actionIndex()
    {
        //вычищение категорий - фильтры
        $filter = \app\modules\shop\models\Filtres::find()->asArray()->all();
        $filter = array_unique(ArrayHelper::merge(ArrayHelper::getColumn($filter, 'id_category'), ArrayHelper::getColumn($filter, 'root_category')));

        $category = new Category();
        $treeFiltres = $category->generateTreeEditCatArr('350');
        $filtersCat = [];
        foreach ($treeFiltres as $k => $v) {
            $filtersCat[] = ''.$k.'';
        }

        //категории, которые скрыты плюсом одна вложенность
        $cat = \app\modules\shop\models\Category::find()->where(['active' => 0])->asArray()->all();
        $cat = ArrayHelper::getColumn($cat, 'id');
        $childCat = \app\modules\shop\models\Category::find()->where(['parent_id' => $cat])->asArray()->all();
        $childCat = ArrayHelper::getColumn($childCat, 'id');

        $models = \app\models\SeoTags::find()->all();
        //*
        foreach($models as $k=>$model) {
            //echo strtotime("now");
            //echo strtotime("-20 day");
            if($model->object === 'Category' && strtotime($model->lasted) < strtotime("-20 day")){
                $model->lasted = date("Y-m-d H:i:s");
                $model->save();
            }
            //var_dump($model->object); exit;
            /*
            if($model['object'] == 'Category' && in_array($model['object_id'],$filtersCat)) continue;
            if($model['object'] == 'Category' && in_array($model['object_id'],$cat)) continue;
            if($model['object'] == 'Category' && in_array($model['object_id'],$childCat)) continue;
            //*/
            $seo[] = $model;
        }
        //*/
        //вычищение товаров - которых нет
        $prod = \app\modules\shop\models\Product::find()->where(['active' => 0])->asArray()->all();
        $prod = ArrayHelper::getColumn($prod, 'id');
        $models = $seo;
        $seo = [];
        foreach($models as $k=>$model) {
            if($model['object'] == 'Product' && in_array($model['object_id'],$prod)) continue;
            $seo[] = $model;
        }

        //создание файла
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        $file = $this->renderPartial('sitemap', [
            'urls' => $seo
        ]);

        $p = '/var/www/apfy.ru/web/sitemap.xml';
        file_put_contents($p, $file);
        return $this->goHome();
    }

//    public function actionTest()
//    {
////  /*
//        //вычищение категорий - фильтры
//
//        $category = new Category();
//        $treeFiltres = $category->generateTreeEditCatArr('350');
//        $filtersCat = [];
//        foreach ($treeFiltres as $k => $v) {
//            $filtersCat[] = $k;
//        }
//        var_dump($treeFiltres);
//        //var_dump($filtersCat);
//        exit;
//        //категории, которые скрыты плюсом одна вложенность
//        $cat = \app\modules\shop\models\Category::find()->where(['active' => 0])->asArray()->all();
//        $cat = ArrayHelper::getColumn($cat, 'id');
//        $childCat = \app\modules\shop\models\Category::find()->where(['parent_id' => $cat])->asArray()->all();
//        $childCat = ArrayHelper::getColumn($childCat, 'id');
//
//        $models = \app\models\SeoTags::find()->all();
//        foreach($models as $k=>$model) {
//            if($model['object'] == 'Category' && in_array($model['object_id'],$filtersCat)) continue;
//            if($model['object'] == 'Category' && in_array($model['object_id'],$cat)) continue;
//            if($model['object'] == 'Category' && in_array($model['object_id'],$childCat)) continue;
//            $seo[] = $model;
//        }
//
//
//        //вычищение товаров - которых нет
//        $prod = \app\modules\shop\models\Product::find()->where(['active' => 0])->asArray()->all();
//        $prod = ArrayHelper::getColumn($prod, 'id');
//        $models = $seo;
//        $seo = [];
//
//        foreach($models as $k=>$model) {
//            if($model['object'] == 'Product' && in_array($model['object_id'],$prod)) continue;
//            $seo[] = $model;
//        }
////*/
//        //для удаление товаров которых нет
////        $cat = \app\modules\shop\models\Category::find()->asArray()->all();
////        $cat = ArrayHelper::getColumn($cat, 'id');
////        $s = \app\models\SeoTags::find()->where(['object'=>'Category'])->asArray()->all();
////        $s = ArrayHelper::getColumn($s, 'object_id');
////        $m = array_diff($s, $cat);
////        \app\models\SeoTags::deleteAll(['object' => 'Category', 'object_id' =>  $m]);
////        $cat = \app\modules\shop\models\Category::find()->asArray()->all();
////        $cat = ArrayHelper::getColumn($cat, 'id');
////        $s = \app\models\SeoTags::find()->where(['object'=>'Category'])->asArray()->all();
////        $s = ArrayHelper::getColumn($s, 'object_id');
////        $m = array_diff($s, $cat);
////        var_dump($m);
////        exit;
//        //создание файла
//        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
//        $headers = Yii::$app->response->headers;
//        $headers->add('Content-Type', 'text/xml');
//
//        return $this->renderPartial('sitemap', [
//            'urls' => $seo
//        ]);
//    }
}
//    public function actionIndex()
//    {
//        $seo = Yii::$app->cache->get('sitemapseo');
//        $seo = false;
//        if($seo == false){
//            $filter = \app\modules\shop\models\Filtres::find()->asArray()->all();
//            $filter = array_unique(ArrayHelper::merge(ArrayHelper::getColumn($filter, 'id_category'), ArrayHelper::getColumn($filter, 'root_category')));
//            $models = \app\models\SeoTags::find()->all();
//            foreach($models as $k=>$model) {
//                if($model['object'] == 'Category' && in_array($model['object_id'],$filter)) continue;
//                if($model['object'] == 'Category' && in_array($model['object_id'],$filter)) continue;
//                $seo[] = $model;
//            }
//            Yii::$app->cache->set('sitemapseo', $seo, 86400);
//        }
//        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
//        $headers = Yii::$app->response->headers;
//        $headers->add('Content-Type', 'text/xml');
//
//        $file = $this->renderPartial('sitemap', [
//            'urls' => $seo
//        ]);
//
//        $p = '/var/www/apfy.ru/web/sitemap.xml';
//        file_put_contents($p, $file);
//        return $this->goHome();
//    }
//return $this->renderPartial('sitemap', [
//    'urls' => $seo
//]);