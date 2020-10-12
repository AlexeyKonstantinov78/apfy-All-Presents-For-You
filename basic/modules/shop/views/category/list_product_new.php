<?php
use app\helpers\Image;
?>

<section class="row">
    <div class="col-xs-12 text-center text-uppercase"><span class="header_filtres" style="font-size: 15px">Найдено <b style="color:#000; margin-left: 10px; display: inline-block"><?=count($products)?></b></span> </div>
    <?php foreach ($products as $k=>$v){ ?>
        <?php // var_dump($v->imagess); exit; ?>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="general_item  transition_02"
                 data-itemid="<?=$v->id?>">
                <?php if(isset($_GET['deb'])): ?>
                    <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="Акция товара"><span >Подробнее об акции!</span></a>
                <?php endif; ?>
                <?php if(!empty($v->imagess)) { ?>
                    <div class="text-center general_item_img">
                        <img alt="<?=$v->name?>"
                             src="<?=Image::thumb($v->imagess->image, null, 260);?>">
                    </div>
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
                    <span class="general_item_price" data-price="<?=$v->discount_price?>">
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
                                    <span class="general_item_pay red_but
                                    transition_02 hover_opaticy" >Купить</span>
                    <span class="general_item_order_fast
                                    general_item_icon hover_opaticy"><i class="fa
                                    fa-plus-square-o" aria-hidden="true"></i></span>
                    <span class="general_item_favorite general_item_icon hover_opaticy
            "><i class="fa
                                    fa-heart" aria-hidden="true"></i></span>
                    <span class="general_item_compare general_item_icon hover_opaticy
            "><i class="fa
                                    fa-columns" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    <?php } ?>
</section>