<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 26.05.2017
 * Time: 3:51
 */
use yii\helpers\Html;
function treeMainItems($cat, $cat_id) {
    if($cat_id!==null) $data = '<ul id="collapse_'.$cat_id.'" class="panel-collapse collapse accordion-group">';
    else $data = '<ul>';
    foreach($cat as $c){
        $data .= '<li>';
        $data .= '<a class="get_ajax_item" href="/root/shop/product/getitem?id='.$c->id.'" >'.$c->name.'</a>';
        if(!$c->isLeaf()) {
            $data .= treeMainItems($c['children'], null);
        }
        $data .= '</li>';
    }
    $data .= '</ul>';
    return $data;
}

$activeLink = isset(Yii::$app->params['breadcrumbs'][1]['url'][0]) ? Yii::$app->params['breadcrumbs'][1]['url'][0] : '';

if(empty($activeLink)) $activeLink = "/category/".Yii::$app->request->get("slug");



/* Cache items */
$category_items = Yii::$app->cache->get('category_items');
//$category_items = false; //отключить кеш
if ($category_items === false) {
    $category_items = '<ul class="filter_admin panel-group" id="filter_admin">';
    foreach($tree as $cat)
    {

        //Html::a($cat->name,'/category/'.($cat->seoTags->slug == null ? $cat->id : $cat->seoTags->slug), ['class' => 'main_cat_href transition_leaner_02 ']); //ссылка категории
        if(!$cat->isLeaf()) {
            $category_items .= '<li class="transition_leaner_02 panel">';
            $category_items .= '<a class="get_ajax_item" href="/root/shop/product/getitem?id='.$cat->id.'" >'.$cat->name.'</a>';
            $category_items .= '<a href="#collapse_'.$cat->id.'" data-toggle="collapse" class="panel-heading" data-parent="#filter_admin" style="font-weight:bold">Показать еще<b class="caret"></b></a>';
            $category_items .= treeMainItems($cat['children'], $cat->id);
        } else {
            $category_items .= '<li class="transition_leaner_02">';
            $category_items .= '<a class="get_ajax_item" href="/root/shop/product/getitem?id='.$cat->id.'" >'.$cat->name.'</a>';
        }
        $category_items .= "</li>";
    }
    $category_items .= "</ul>";
    Yii::$app->cache->set('category_items', $category_items, 1000);
}
?>
<div class="row">
    <div class="col-xs-12 filter_admin">
        <?=$category_items?>
    </div>
</div>

