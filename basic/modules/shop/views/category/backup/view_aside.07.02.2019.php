<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use app\modules\shop\models\Category;
use app\assets\OwlAsset;
use app\widgets\html\HtmlWidget;
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
if(!isset($_GET['debager'])) {
    $js = <<<JS
$(document).ready( function(){
    //*
    $('#activeFiltres').on('click', function (event) {

        $.get( $('#filters').attr('action'), $('#filters').serialize(), function( data ) {
            $('#category_products').html( data );
        });
        //event.preventDefault();
        //console.log( $(this).attr('action') );
    });
    //*/
    if($(window).width() > 991){
        $(window).scroll(function(){
            var top_aside = $('aside').offset().top;
            var the_end = $('article').offset().top;
            the_end = the_end - 850;
            if ($(window).scrollTop() > top_aside && $(window).scrollTop() < the_end) {
                $('aside form').addClass('form_fixed');
            } else {
                $('aside form').removeClass('form_fixed');
            }
        })
    }
});
JS;
    $this->registerJs($js);
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
    if($(window).width() > 991){
        $(window).scroll(function(){
            var top_aside = $('aside').offset().top;
            if ($(window).scrollTop() > top_aside) {
                $('aside form').addClass('form_fixed');
            } else {
                $('aside form').addClass('form_fixed');
            }
        });
    }
    
";
$a = 0;

?>
<?php $sub_cats = []; ?>
<?php if($model->isLeaf() === false) { ?>
    <?php foreach($model->children as $ch) {?>
        <?php $sub_cats[] = [
            'name' => $ch->name,
            'id' => $ch->id
        ]; ?>
    <?php } ?>
<?php } ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?=app\models\BreadcrumbsMicro::widget([
                    'homeLink' => [
                        'label' => 'Главная',
                        'url' => Yii::$app->homeUrl,
                    ],
                    //'itemTemplate' => '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">{link}</span><span class="itemSeparator">/</span></li>',
                    //'links' => isset(Yii::$app->params['breadcrumbs']) ? Yii::$app->params['breadcrumbs'] : [],
                    'links' => isset(Yii::$app->params['breadcrumbs']) ? Yii::$app->params['breadcrumbs'] : [],
                    'options' => [
                        'id' => 'breadcrumbs',
                        'style' => 'border-bottom: 1px solid #f3eccd;',
                    ],
                ]
            )?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center">
            <hr class="gold_hr" />
            <h1 class="h2 header_light h_gold text-uppercase"><?=empty($model->seoTags->h1) ? $model->name : $model->seoTags->h1?></h1>
        </div>
    </div>
</div>




<?php $sub_cats = []; ?>
<?php if(!empty($_GET['a'])) { ?>
    <?php if($model->isLeaf() === false) { ?>
        <div class="text-center" style="margin-top: 30px; display: none">
            <hr class="gold_hr"/>
            <h3 class="h2 header_light h_gold text-uppercase">Разделы категории <?=$model->name?></h3>
        </div>
        <div class="container sub_cats clearfix" id="cat_sub_cats">
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
        <?php if(count($sub_cats)>4) $this->registerJs($jsI); ?>
    <?php } ?>
<?php } else { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul id="cat_sub_cats_flex">
                    <?php foreach($model->children as $ch) {?>
                        <?php //TODO ?>
                        <?php if($ch->active == 0) Continue; ?>
                        <li class="transition_02">
                            <a href="<?='/category/'.($ch->seoTags->slug == null ?
                                $ch->id : $ch->seoTags->slug)?>"
                               title="<?=$ch->name?>"
                               class="transition_02 img_sub">
                                <img src="<?=$ch->mainImage->thumb(240)?>" alt="<?=$ch->name?>"/>
                            </a>
                            <a href="<?='/category/'.($ch->seoTags->slug == null ?
                                $ch->id : $ch->seoTags->slug)?>"
                               title="<?=$ch->name?>"
                               class="transition_02 sub_cuts_href">
                                <?=$ch->name?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
<?php } ?>
<hr/>
<?php if(count($products) > 0) { ?>
    <div class="container">
        <?php if(!isset($_GET['debager'])) { ?>
            <aside class="col-md-3">
                <h3 class="h4 text-center text-uppercase">Фильтры товаров:</h3>
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
                    <div class="col-xs-12">
                        <span class="header_filtres text-center text-uppercase">По алфавиту</span>
                        <select name="name" class="form-control select_filters">
                            <option value="" selected>по умолчанию</option>
                            <option value="ASC">А->Я</option>
                            <option value="DESC">Я->А</option>
                        </select>
                    </div>
                    <div class="col-xs-12">
                        <span class="header_filtres text-center text-uppercase">Цена</span>
                        <select name="price" class="form-control select_filters">
                            <option value="" selected>по умолчанию</option>
                            <option value="ASC">По возрастанию</option>
                            <option value="DESC">По убыванию</option>
                        </select>
                    </div>
                    <?php if(count($sub_cats) > 0) { ?>
                        <div class="col-xs-12">
                            <span class="header_filtres text-center text-uppercase">Раздел</span>
                            <select name="cats[]" class="form-control select_filters">
                                <option value="" selected>по умолчанию</option>
                                <?php foreach($sub_cats as $c) {?>
                                    <option value="<?=$c['id']?>"><?=$c['name']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                    <div class="col-xs-12 text-center">
                        <button type="button" class="transition_02 none_outline default_button text-uppercase red_but_font_filt" id="activeFiltres" style="margin-top: 42px">
                            Применить фильтры
                        </button>
                    </div>
                <?php } else { ?>
                    <div class="col-xs-12">
                        <span class="header_filtres text-center text-uppercase">По алфавиту</span>
                        <select name="name" class="form-control select_filters">
                            <option value="" selected>по умолчанию</option>
                            <option value="ASC">А->Я</option>
                            <option value="DESC">Я->А</option>
                        </select>
                    </div>
                    <div class="col-xs-12">
                        <span class="header_filtres text-center text-uppercase">Цена</span>
                        <select name="price" class="form-control select_filters">
                            <option value="" selected>по умолчанию</option>
                            <option value="ASC">По возрастанию</option>
                            <option value="DESC">По убыванию</option>
                        </select>
                    </div>
                    <?php if(count($sub_cats) > 0) { ?>
                        <div class="col-xs-12">
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
                        <div class="col-xs-12 collapse fade_extendFiltres" style=" ">
                            <span class="header_filtres text-center text-uppercase"><?=$filter['root']['name']?></span>
                            <select name="cats[]" class="form-control select_filters">
                                <option value="" selected>по умолчанию</option>
                                <?php foreach ($filter['root']['children'] as $filterChildren) { ?>
                                    <option value="<?=$filterChildren['id']?>"><?=$filterChildren['name']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                    <div class="col-xs-12 text-center">
                        <button id="button_filtr" type="button" class="transition_02 none_outline default_button text-uppercase red_but_font "
                                data-toggle="collapse" data-target=".fade_extendFiltres" aria-expanded="false" style="border:none !important; ">
                            <span>Дополнительные фильтры</span> <i class="fa fa-angle-up transition_02" aria-hidden="true" style="margin-left: 6px;"></i>

                        </button>
                        <button type="button" class="transition_02 none_outline default_button text-uppercase red_but_font_filt" id="activeFiltres" >
                            Применить фильтры
                        </button>
                    </div>
                <?php } ?>
                <?php //</section> ?>
                <?php ActiveForm::end(); ?>
            </aside>
        <?php } else { ?>
            <?= HtmlWidget::widget(['id' => $model->id, 'tmp' => 'filter-test', 'cats' => $sub_cats, 'model' => $filterCache])
            //если нет with_id, то действует выбирает по with_ParentId (parent_id) ?>
        <?php } ?>
        <main class="col-md-9">
            <h2 class="text-uppercase h4 text-center">Товары раздела <?=empty($model->seoTags->h1) ? $model->name : $model->seoTags->h1?></h2>
            <hr/>
            <div id="category_products">
                <section class="row">
                    <?php foreach ($products as $k=>$v){ ?>
                        <?php $v->name = empty($v->seoTags->h1) ? $v->name : $v->seoTags->h1; ?>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="general_item  transition_02">
                                <?php if(!empty($v->discount_price) && $v->discount_price>0) : ?>
                                    <?php if($v->discount_price > 5000 && isset($gen)): ?>
                                        <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
                                    <?php endif; ?>
                                <?php elseif ($v->price > 5000): ?>
                                    <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
                                <?php endif; ?>
                                <?php if($v->mainImage != null) { ?>
                                    <a class="text-center general_item_img" href="/product/<?=$v->seoTags->slug?>">
                                        <img alt="<?=$v->name?>"
                                             src="<?=$v->mainImage->thumb(null, 260)?>">
                                    </a>
                                <?php } ?>
                                <span class="item_stock clearfix"></span>
                                <div class="general_item_desc">
                                    <a class="transition_02" href="/product/<?=$v->seoTags->slug?>"
                                       title="<?=$v->name?>"><?=$v->name?></a>
                                </div>
                                <hr class="gold_hr"/>
                                <?php if(!empty($v->discount_price) && $v->discount_price>0): ?>
                                    <span class="general_item_price general_item_price_dis" data-price="<?=$v->discount_price?>">
                                        <?=number_format($v->discount_price,0,'',' ');?>
                                        <span class="general_item_currency">руб.</span>
                                    </span>
                                    <span class="general_item_price_discount">
                                        <?=number_format($v->price,0,'',' ');?>
                                        <span class="general_item_currency">руб.</span>
                                    </span>
                                <?php else: ?>
                                    <span class="general_item_price" data-price="<?=$v->price?>">
                                        <?=number_format($v->price,0,'',' ');?>
                                        <span class="general_item_currency">руб.</span>
                                    </span>
                                <?php endif; ?>
                                <div class="general_add">
                                    <span class="general_item_pay add_to_cart red_but
                                    transition_02 hover_opaticy" data-id="<?=$v->id?>" data-href="/product/<?=$v->seoTags->slug?>">Добавить в корзину</span>
                                    <span class="general_item_order_fast general_item_icon hover_opaticy"  data-id="<?=$v->id?>" data-toggle="tooltip"  title="Купить в один клик" >
                                        <i class="general_item_icon_fast general_item_icon_fast_1"></i>
                                    </span>
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
        </main>
    </div>
<?php } else {
    echo '<hr style="border: none; background: none; outline:none; min-height: calc(100vh - 750px); width:100%; display: block;">';
} ?>



<?php if($model->description) { ?>
    <div class="container" style="margin-bottom: 50px; margin-top: 30px">
        <div class="row">
            <article class="col-xs-12 cols_2_description text-left first_p">
                <?=$model->description?>
            </article>
        </div>
    </div>
<?php } ?>



