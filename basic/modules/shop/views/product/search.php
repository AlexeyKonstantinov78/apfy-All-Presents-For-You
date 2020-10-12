<?php
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\helpers\Image;
?>
<main class="container" id="search_page">

    <div class="row">
        <div class="col-xs-12 text-center">
            <hr class="gold_hr"/>
            <h1 class="h2 header_light h_gold text-uppercase">Поиск</h1>
        </div>
    </div>
    <div class="input_panel row clear">
        <form name="search" class=" searching input_panel_section" action="/search/">
            <div class="input-group col-xs-12">
                <input type="text" class="black_white_form form-control none_outline transition_02" name="text" value="<?=\Yii::$app->request->get('query')?>" placeholder="Поиск..." />
                <button class="input-group-addon item_quant black_white_form  transition_02" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </form>
    </div>
    <?php if(!is_null($models)): ?>
        <section class="row">
            <div class="col-xs-12 text-center text-uppercase">
                <span class="header_filtres" style="font-size: 15px">Найдено товаров по запросу "<?=\Yii::$app->request->get('query')?>" - <b style="color:#000; margin-left: 10px; display: inline-block"><?=count($models)?></b></span>
            </div>

            <?php foreach ($models as $k=>$v){ ?>
                <?php $v->name = empty($v->seoTags->h1) ? $v->name : $v->seoTags->h1; ?>
                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12">
                    <div class="general_item  transition_02">
                        <?php if(!empty($v->discount_price) && $v->discount_price>0) : ?>
                            <?php if($v->discount_price > 555000): ?>
                                <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
                            <?php endif; ?>
                        <?php elseif ($v->price > 5000): ?>
                            <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
                        <?php endif; ?>
                        <?php if($v->mainImage != null) { ?>
                            <a href="/product/<?=$v->seoTags->slug?>" title="<?=$v->name?>" class="text-center general_item_img">
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
    <?php endif; ?>
</main>
