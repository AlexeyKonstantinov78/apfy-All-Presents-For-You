<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 06.03.2017
 * Time: 6:15
 */
use yii\helpers\Html;
function treeMainItems($cat, $max_level) {
    $max_level--;
    $data = "";
    if($max_level > 0) {
        foreach($cat as $c){
            if($c->active == 0) Continue;
            //$data .= '<span  class="">';
            $data .= Html::a($c->name,'/category/'.($c->seoTags->slug == null ? $c->id : $c->seoTags->slug), ['class' => 'transition_02', 'data-img'=>$c->mainImage->thumb(240)]);
            //$data .= '</span>';
        }
    }
    return $data;
}

$activeLink = isset(Yii::$app->params['breadcrumbs'][1]['url'][0]) ? Yii::$app->params['breadcrumbs'][1]['url'][0] : '';

if(empty($activeLink)) $activeLink = "/category/".Yii::$app->request->get("slug");

$max_level = 2;


/* Cache items */
$items = Yii::$app->cache->get('items');
$items = false; //отключить кеш
if ($items === false) {
    $items = '<div id="collapseMenu_1" class="collapse other_collapse "><div class="container"><div class="row"><ul class="ver_2_sub_menu col-lg-8 col-md-9 col-xs-12">';
    foreach($tree as $cat)
    {
        if($cat->active == 0) Continue;
        $items .= '<li class=" ">';
        $items .= '<a href="/category/'.($cat->seoTags->slug == null ? $cat->id : $cat->seoTags->slug).'" data-img="'.$cat->mainImage->thumb(240).'" class="transition_02 general_cat text-uppercase"><b>'.$cat->name.'</b></a>';
        //Html::a($cat->name,'/category/'.($cat->seoTags->slug == null ? $cat->id : $cat->seoTags->slug), ['class' => 'main_cat_href transition_leaner_02 ']); //ссылка категории
        if($max_level > 0 && !$cat->isLeaf()) {
            $items .= treeMainItems($cat['children'], $max_level);
        }
        $items .= "</li>";
    }
    $items .= "</ul><div class='col-lg-4 col-md-3 visible-lg visible-md'><img id='menu_img_cat' src='/img/site/test/cat_menu.jpg'></div></div></div></div>";
    Yii::$app->cache->set('items', $items, 10000);
}
?>
<nav>
    <button type="button" class="navbar-toggle mob_button" data-toggle="collapse" data-parent="#top_bar" data-target="#navbar_main" aria-expanded="false" aria-controls="navbar_main">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <ul class="main_menu collapse" id="navbar_main">
        <li>
            <a href="/" class="transition_02">
                Главная
            </a>
        </li>
        <li>
            <a class="list_catalog transition_02 collapsed all_collapse"
               data-toggle="collapse" data-parent="#top_menu"
               href="#collapseMenu_1" >
                Каталог
            </a>
            <?=$items?>
        </li>
        <li>
            <a class="transition_02" href="/category/rasprodazha">
                <b class="text-uppercase">Распродажа!</b>
            </a>
        </li>
        <li>
            <a class="transition_02" href="/category/novinki">
                <b class="text-uppercase">Новинки!</b>
            </a>
        </li>
        <li>
            <a class="transition_02" href="/page/delivery">
                Доставка и оплата
            </a>
        </li>
        <li>
            <a class="transition_02" href="/page/garantii-i-vozvrat">
                Гарантии и возврат
            </a>
        </li>
    </ul>
</nav>