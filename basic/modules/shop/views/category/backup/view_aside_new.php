<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use app\assets\OwlAsset;
use app\widgets\filters\FiltersWidget;
OwlAsset::register($this);

$this->registerCssFile('/css/site/pagesCss/category.css');

/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Category */
//*testing
//var_dump($model->isLeaf());
//exit;
//$this->registerCssFile('/css/site/pagesCss/category.css');
$js = <<<JS
if($('#cat_sub_cats_flex li').length > 6){
	$('#cat_sub_cats_flex').owlCarousel({
        loop:false,
        margin:10,
        nav:true,
        dots: false,
        navText: ['<i class=\"fa fa-angle-left\" aria-hidden=\"true\"></i>','<i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i>'],
        responsive:{
            0:{
                items:2,
                nav:true,
            },
            400:{
                items:3,
                nav:true,
            },
            500:{
                items:4,
                nav:true,
            },
            768:{
                items:6,
                nav:true,
            },
            1000:{
                items:6,
                nav:true,
            },
            1200:{
                items:8,
                nav:true,
            },
        }
    })
}	
JS;
//if(isset($_GET['debi']))
if($model->id != 86)
    $this->registerJs($js);

$a = 0;
?>

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

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <ul id="cat_sub_cats_flex" class="owl-carousel">
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

<hr/>

<?php if(count($products) > 0) { ?>
    <div class="container">
        <?php if(!isset($_GET['cat'])): ?>
            <?=FiltersWidget::widget(['id' => $model->id, 'tmp' => 'filters', 'model' => $filtres, 'price' => $priceMinMax]) ?>
        <?php else: ?>
            <?=FiltersWidget::widget(['id' => $model->id, 'tmp' => 'filtersTest', 'model' => $filtres, 'price' => $priceMinMax]) ?>
        <?php endif; ?>
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
                                <?php if($v->active == 1): ?>
                                    <span class="item_stock_11 item_stock clearfix"><!--В наличии--></span>
                                <?php else: ?>
                                    <span class="item_stock_21 item_stock clearfix"><!--Под заказ--></span>
                                <?php endif; ?>
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
                                    <?php if($v->active == 1): ?>
                                        <span class="general_item_pay add_to_cart red_but
                                        transition_02 hover_opaticy" data-id="<?=$v->id?>" data-href="/product/<?=$v->seoTags->slug?>">Добавить в корзину</span>
                                        <span class="general_item_order_fast general_item_icon hover_opaticy"  data-id="<?=$v->id?>" data-toggle="tooltip"  title="Купить в один клик" >
                                            <i class="general_item_icon_fast general_item_icon_fast_1"></i>
                                        </span>
                                    <?php else: ?>
                                        <span class="general_item_order_under red_but
                                        transition_02 hover_opaticy" data-id="<?=$v->id?>" data-href="/product/<?=$v->seoTags->slug?>">Под заказ</span>
                                    <?php endif; ?>
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



