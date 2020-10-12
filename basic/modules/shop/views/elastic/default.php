<?php
use app\helpers\Image;

//var_dump($products); exit;
?>
<section class="row">
    <?php foreach ($products as $k=>$v){ ?>
        <?php //var_dump($v->slug); exit; ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="general_item  transition_02">
                <?php if(!empty($v->discount_price) && $v->discount_price>0) : ?>
                    <?php if($v->discount_price > 5000): ?>
                        <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
                    <?php endif; ?>
                <?php elseif ($v->price > 5000): ?>
                    <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
                <?php endif; ?>
                <?php if($v->image != null) { ?>
                    <a target="_blank" class="text-center general_item_img" href="/product/<?=$v->slug?>">
                        <img alt="<?=$v->name?>"
                             src="<?=Image::thumb($v->image,null, 260)?>">
                    </a>
                <?php } ?>
                <?php if($v->active == 1): ?>
                    <span class="item_stock_11 item_stock clearfix"><!--В наличии--></span>
                <?php else: ?>
                    <span class="item_stock_21 item_stock clearfix"><!--Под заказ--></span>
                <?php endif; ?>
                <div class="general_item_desc">
                    <a class="transition_02" target="_blank" href="/product/<?=$v->slug?>"
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
                                        transition_02 hover_opaticy" data-id="<?=$v->product_id?>" data-href="/product/<?=$v->slug?>">Добавить в корзину</span>
                        <span class="general_item_order_fast general_item_icon hover_opaticy"  data-id="<?=$v->product_id?>" data-toggle="tooltip"  title="Купить в один клик" >
                                            <i class="general_item_icon_fast general_item_icon_fast_1"></i>
                                        </span>
                    <?php else: ?>
                        <span class="general_item_order_under red_but
                                        transition_02 hover_opaticy" data-id="<?=$v->product_id?>" data-href="/product/<?=$v->slug?>">Под заказ</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php } ?>
</section>