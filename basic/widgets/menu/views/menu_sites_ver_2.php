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
            $data .= '<span  class="cat_href_in_span">';
            $data .= Html::a($c->name,'/category/'.($c->seoTags->slug == null ? $c->id : $c->seoTags->slug), ['class' => 'sub_cat_href transition_ reter_02']);
            $data .= '</span>';
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
    $items = '<ul id="collapseMenu_1" class="collapse container ver_2_sub_menu">';
    foreach($tree as $cat)
    {
        if($cat->active == 0) Continue;
        $items .= '<li class="sub_menu_cat transition_leaner_02">';
        $items .= '<a href="/category/'.($cat->seoTags->slug == null ? $cat->id : $cat->seoTags->slug).'" class="main_cat_href transition_leaner_02"><i class="glyphicon glyphicon-menu-right transition_leaner_02" aria-hidden="true"></i>'.$cat->name.'</a>';
            //Html::a($cat->name,'/category/'.($cat->seoTags->slug == null ? $cat->id : $cat->seoTags->slug), ['class' => 'main_cat_href transition_leaner_02 ']); //ссылка категории
        if($max_level > 0 && !$cat->isLeaf()) {
            $items .= treeMainItems($cat['children'], $max_level);
        }
        $items .= "</li>";
    }
    $items .= "</ul>";
    Yii::$app->cache->set('items', $items, 1000);
}
?>
<nav class="transition--fade"> <!--nav--open и добавить высоту, дополнительные открываются при помощи active-->
    <div class="nav-bar nav--absolute mobile_menu_active11 nav--transparent" data-fixed-at="200"> <!--nav--fixed class дополнительный-->
        <div class="nav-module logo-module left">
            <a href="index.html">
                <img class="logo logo-dark" alt="logo" src="/img/tmp/logo-dark.png" />
                <img class="logo logo-light" alt="logo" src="/img/tmp/logo-light.png" />
            </a>
            <span id="menu_close" class="close_default"></span>
        </div>
        <div class="nav-module menu-module left ">

            <ul class="menu">
                <li>
                    <a href="/">
                        Главная
                    </a>
                </li>
                <li>
                    <a data-toggle="collapse" data-parent="#top_menu" href="#collapseMenu_1">
                        Категории товаров
                    </a>
                    <?=$items?>
                </li>
                <li>
                    <a href="/site/about">
                        О нас
                    </a>
                </li>
                <li>
                    <a href="/site/contacts">
                        Контакты
                    </a>
                </li>
            </ul>
        </div>
        <!--end nav module-->
        <div class="right utils_bar">
            <div class="nav-module pull-left">

                <form class="navbar-form forms-label-admin" action="/root/logout" method="post">
                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>"><button type="submit" class="btn btn-link "><i class="fa fa-fw fa-power-off"></i> Выйти</button></form>',
                <a href="/cabinet/" class="nav-function" data-notification-link="cart-overview" title="Вход">
                    <i class="interface-user icon icon--sm" style="font-size: 12px"></i>
                    <span>Пользователь</span>
                </a>
            </div>
            <div class="nav-module right">
                <a href="#" class="nav-function" data-notification-link="cart-overview">
                    <i class="interface-bag icon icon--sm"></i>
                    <span>Корзина</span>
                </a>
            </div>
            <div class="nav-module right">
                <!--a href="#" class="nav-function modal-trigger" data-modal-id="search-form">
                    <i class="interface-search icon icon--sm"></i>
                    <span>Поиск</span>
                </a-->
            </div>
        </div>
    </div>
    <!--end nav bar-->
    <div class="nav-mobile-toggle visible-sm visible-xs">
        <i class="icon-Align-Right icon icon--sm img-circle"></i>
    </div>
    <div class="basket_in_mobile  visible-sm visible-xs ">
        <a href="#" class="nav-function" data-notification-link="cart-overview">
            <i class="interface-bag icon icon--sm img-circle"></i>
        </a>
    </div>
</nav>