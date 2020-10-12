<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use app\modules\shop\models\Category;
use app\assets\OwlAsset;
OwlAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Category */
//*testing
//var_dump($model->isLeaf());
//exit;
$this->registerCssFile('/css/site/pagesCss/category.css');

$filterCache = Yii::$app->cache->get('filter-'.$model->id);
//var_dump($filtres);
$filterCache = Category::generateBadFiltresCats($filtres);
if ($filterCache === false) {
    $filterCache = Category::generateBadFiltresCats($filtres);
    Yii::$app->cache->set('filter-'.$model->id, $filterCache, 100000000);
}
$this->registerJsFile('/js/site/pages/category.js', ['depends'=> ['app\assets\AppAsset'],'position' => \yii\web\View::POS_END]);
$jsI="
    $('#cat_sub_cats .owl-carousel').owlCarousel({
        loop:false,
        margin:10,
        nav:true,
        dots: false,
        navText: ['<i class=\"fa fa-angle-left\" aria-hidden=\"true\"></i>','<i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i>'],
        responsive:{
            0:{
                items:1,
                nav:true,
            },
            768:{
                items:3,
                nav:true,
            },
            1000:{
                items:4,
                nav:true,
            }
        }
    })
";
$a = 0;
?>
<div class="container">
    <div class="row">
        <?=Breadcrumbs::widget([
            'homeLink' => [
                'label' => 'Главная',
                'url' => Yii::$app->homeUrl,
            ],
            'itemTemplate' => '{link} <span>/</span>',
            'links' => isset(Yii::$app->params['breadcrumbs']) ? Yii::$app->params['breadcrumbs'] : [],
            'options' => [ 'id' => 'breadcrumbs', 'class' => 'col-xs-12', 'style' => '
    border-bottom: 1px solid #f3eccd;' ],
            'activeItemTemplate' => '{link}',
            'tag' => 'div',
        ])?>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center">
            <hr class="gold_hr" style="margin-bottom: 26px"/>
            <h1 class="h2 header_light h_gold text-uppercase"><?=$model->name?></h1>
        </div>
    </div>
</div>
<main>
    <?php $sub_cats = []; ?>
    <?php if($model->isLeaf() === false) { ?>
        <div class="container sub_cats clearfix" id="cat_sub_cats" style="margin-bottom: 10px">
            <div class="owl-carousel owl_nav">
                <?php foreach($model->children as $ch) {?>
                    <?php $sub_cats[] = [
                        'name' => $ch->name,
                        'id' => $ch->id
                    ]; ?>
                    <div class="item sub_cut text-center">
                        <div class="sub_cuts_img">
                            <a href="<?='/category/'.($ch->seoTags->slug == null ?
                                $ch->id : $ch->seoTags->slug)?>"
                               title="<?=$ch->name?>"
                               class="transition_02">
                                <img src="<?=$ch->mainImage->thumb(240)?>" alt="<?=$ch->name?>"/>
                            </a>
                        </div>
                        <div class="sub_cuts_href">
                            <a href="<?='/category/'.($ch->seoTags->slug == null ?
                                $ch->id : $ch->seoTags->slug)?>"
                               title="<?=$ch->name?>"
                               class="transition_02">
                                <?=$ch->name?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php
        if(count($sub_cats)>4) $this->registerJs($jsI);
        ?>

    <?php } ?>
    <?php if($model->description && $a == 1) { ?>
        <section class="container">
            <div class="row">
                <article class="col-xs-12 cols_2_description text-left first_p">
                    <?=$model->description?>
                </article>
            </div>
        </section>
    <?php } ?>
    <?php if(count($products) > 0) { ?>
        <div class="container">
            <?php $form = ActiveForm::begin([
                'id' => 'filters',
                'action' => '/shop/category/ajax',
                'options' => [
                    'class' => 'row'
                ],
                'enableClientValidation' => false,
                'enableAjaxValidation' => Yii::$app->request->isAjax ? true : false,
            ]); ?>
            <?php //<section class="row" id="filters"> ?>
            <input type="hidden" name="cats[]" value="<?=$model->id?>">
            <?php if(empty($filterCache)){ ?>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <span class="header_filtres text-center text-uppercase">По алфавиту</span>
                    <select name="name" class="form-control select_filters">
                        <option value="" selected>по умолчанию</option>
                        <option value="ASC">А->Я</option>
                        <option value="DESC">Я->А</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <span class="header_filtres text-center text-uppercase">Цена</span>
                    <select name="price" class="form-control select_filters">
                        <option value="" selected>по умолчанию</option>
                        <option value="ASC">По возрастанию</option>
                        <option value="DESC">По убыванию</option>
                    </select>
                </div>
                <?php if(count($sub_cats) > 0) { ?>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <span class="header_filtres text-center text-uppercase">Раздел</span>
                        <select name="cats[]" class="form-control select_filters">
                            <option value="" selected>по умолчанию</option>
                            <?php foreach($sub_cats as $c) {?>
                                <option value="<?=$c['id']?>"><?=$c['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>
                <div class="col-md-3 col-xs-12 text-center">
                    <button type="button" class="transition_02 none_outline default_button text-uppercase red_but_font_filt" id="activeFiltres" style="margin-top: 42px">
                        Применить фильтры
                    </button>
                </div>
            <?php } else { ?>
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <span class="header_filtres text-center text-uppercase">По алфавиту</span>
                    <select name="name" class="form-control select_filters">
                        <option value="" selected>по умолчанию</option>
                        <option value="ASC">А->Я</option>
                        <option value="DESC">Я->А</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <span class="header_filtres text-center text-uppercase">Цена</span>
                    <select name="price" class="form-control select_filters">
                        <option value="" selected>по умолчанию</option>
                        <option value="ASC">По возрастанию</option>
                        <option value="DESC">По убыванию</option>
                    </select>
                </div>
                <?php if(count($sub_cats) > 0) { ?>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <span class="header_filtres text-center text-uppercase">Раздел</span>
                        <select name="cats[]" class="form-control select_filters">
                            <option value="" selected>по умолчанию</option>
                            <?php foreach($sub_cats as $c) {?>
                                <option value="<?=$c['id']?>"><?=$c['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>
                <!--                <section id="extendFiltres" class="collapse fade">-->
                <?php foreach ($filterCache as $filter){ ?>
                    <div class="col-md-3 col-sm-4  col-xs-12 collapse fade_extendFiltres" style=" ">
                        <span class="header_filtres text-center text-uppercase"><?=$filter['root']['name']?></span>
                        <select name="cats[]" class="form-control select_filters">
                            <option value="" selected>по умолчанию</option>
                            <?php foreach ($filter['root']['children'] as $filterChildren) { ?>
                                <option value="<?=$filterChildren['id']?>"><?=$filterChildren['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>
                <!--                </section>-->
                <div class="col-md-3  col-sm-4 col-xs-12 text-center">
                    <button type="button"
                            class="transition_02 none_outline default_button text-uppercase red_but_font "
                            data-toggle="collapse" data-target=".fade_extendFiltres" aria-expanded="false" style="border:none !important; margin-top: 40px">
                        <span>Расширенные фильтры</span> <i class="fa fa-angle-up transition_02" aria-hidden="true" style="margin-left: 6px;"></i>

                    </button>
                </div>
                <div class="col-md-3  col-sm-4 col-xs-12 text-center">
                    <button type="button" class="transition_02 none_outline default_button text-uppercase red_but_font_filt" id="activeFiltres" style="margin-top: 40px">
                        Применить фильтры
                    </button>
                </div>
            <?php } ?>
            <?php //</section> ?>
            <?php ActiveForm::end(); ?>
            <div id="category_products">
                <section class="row">
                    <?php foreach ($products as $k=>$v){ ?>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="general_item  transition_02">
                                <?php if($v->mainImage != null) { ?>
                                    <div class="text-center general_item_img">
                                        <img alt="<?=$v->name?>"
                                             src="<?=$v->mainImage->thumb(null, 260)?>">
                                    </div>
                                <?php } ?>
                                <span class="item_stock clearfix"></span>
                                <div class="general_item_desc">
                                    <a class="transition_02" href="/product/<?=$v->seoTags->slug?>"
                                       title="<?=$v->name?>"><?=$v->name?></a>
                                </div>
                                <hr class="gold_hr"/>
                                <span class="general_item_price" data-price="<?=$v->price?>">
                                    <?=number_format($v->price,0,'',' ');?>
                                    <span class="general_item_currency">руб.</span>
                                </span>
                                <div class="general_add">
                                    <span class="general_item_pay add_to_cart red_but
                                    transition_02 hover_opaticy" data-id="<?=$v->id?>" data-href="/product/<?=$v->seoTags->slug?>">Добавить в корзину</span>
                                    <span class="general_item_order_fast general_item_icon hover_opaticy"  data-id="<?=$v->id?>" data-toggle="tooltip"  title="Купить в один клик" ><i class="fa fa-paper-plane" aria-hidden="true"></i></span>
                                    <!--                                    <span class="general_item_order_fast-->
                                    <!--                                    general_item_icon hover_opaticy"><i class="fa-->
                                    <!--                                    fa-plus-square-o" aria-hidden="true"></i></span>-->
                                    <!--                                    <span class="general_item_favorite general_item_icon hover_opaticy-->
                                    <!--            "><i class="fa-->
                                    <!--                                    fa-heart" aria-hidden="true"></i></span>-->
                                    <!--                                    <span class="general_item_compare general_item_icon hover_opaticy-->
                                    <!--            "><i class="fa-->
                                    <!--                                    fa-columns" aria-hidden="true"></i></span>-->
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </section>
                <section class="row">
                    <div class="col-xs-12 text-center">
                        <div class="pagination-container pagination_dis">
                            <?=yii\widgets\LinkPager::widget(array(
                                'pagination' => $pages,
                                'prevPageLabel'=>'<i class="fa fa-angle-left transition_02" aria-hidden="true"></i>',
                                'nextPageLabel'=>'<i class="fa fa-angle-right transition_02" aria-hidden="true"></i>',
//                                'options' => [
//                                    'class' => 'filter_nav',
//                                    'firstPageLabel' => '',
//                                    'lastPageLabel' => '',
//                                    'prevPageLabel' => '<i class="fa fa-angle-left transition_02" aria-hidden="true"></i>',
//                                    'nextPageLabel' => '<i class="fa fa-angle-right transition_02" aria-hidden="true"></i>',
//                                    'firstPageLabel' => '<i class="fa fa-angle-left transition_02" aria-hidden="true"></i>',
//                                    'lastPageLabel' => '<i class="fa fa-angle-right transition_02" aria-hidden="true"></i>',
//                                    'pageCssClass' => 'filter_nav',
//                                    'nextPageCssClass' => 'prev_s',
//                                    'nextPageCssClass' => 'next_s',
//
//                                    'firstPageCssClass' => 'lknflbes',
                                //'maxButtonCount' => 1,
//                                ]
                            ));?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    <?php } ?>
    <?php if($model->description) { ?>
        <section class="container">
            <div class="row">
                <article class="col-xs-12 cols_2_description text-left first_p">
                    <?=$model->description?>
                </article>
            </div>
        </section>
    <?php } ?>
</main>



