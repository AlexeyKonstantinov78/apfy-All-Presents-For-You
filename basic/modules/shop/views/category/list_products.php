<?php
use app\helpers\Image;

?>

<section class="row">
    <div class="col-xs-12 text-center text-uppercase"><span class="header_filtres" style="font-size: 15px">Найдено <b style="color:#000; margin-left: 10px; display: inline-block"><?=count($products)?></b></span> </div>
    <?php foreach ($products as $k=>$v){ ?>
        <?php $v['name'] = empty($v['seoTags']['h1']) ? $v['name'] : $v['seoTags']['h1']; ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="general_item  transition_02">
                <?php if(!empty($v['discount_price']) && $v['discount_price']>0) : ?>
                    <?php if($v['discount_price']> 5000): ?>
                        <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
                    <?php endif; ?>
                <?php elseif ($v['price'] > 5000): ?>
                    <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
                <?php endif; ?>
                <?php if(!empty($v['image'])) { ?>
                    <a target="_blank" href="/product/<?=$v['slug']?>"
                       title="<?=$v['name']?>" class="text-center general_item_img">
                        <img alt="<?=$v['name']?>"
                             src="<?=Image::thumb($v['image'], null, 260);?>">
                    </a>
                <?php } ?>
                <span class="item_stock clearfix"></span>
                <div class="general_item_desc">
                    <a target="_blank" class="transition_02" href="/product/<?=$v['slug']?>"
                       title="<?=$v['name']?>"><?=$v['name']?></a>
                </div>
                <hr class="gold_hr"/>
                <?php
//                    var_dump();
//                    exit;
                ?>
                <?php if(!empty($v['discount_price']) && $v['discount_price']>0): ?>
                    <span class="general_item_price general_item_price_dis" data-price="<?=$v['discount_price']?>">
                        <?=number_format($v['discount_price'],0,'',' ');?>
                        <span class="general_item_currency">руб.</span>
                    </span>
                    <span class="general_item_price_discount">
                        <?=number_format($v['price'],0,'',' ');?>
                        <span class="general_item_currency">руб.</span>
                    </span>
                <?php else: ?>
                    <span class="general_item_price" data-price="<?=$v['price']?>">
                    <?=number_format($v['price'],0,'',' ');?>
                        <span class="general_item_currency">руб.</span>
                    </span>
                <?php endif; ?>
                <div class="general_add">
                    <span class="general_item_pay add_to_cart red_but transition_02 hover_opaticy" data-id="<?=$v['id']?>" data-href="/product/<?=$v['slug']?>">Добавить в корзину</span>
                    <span class="general_item_order_fast general_item_icon hover_opaticy"  data-id="<?=$v['id']?>" data-toggle="tooltip"  title="Купить в один клик" >
                        <i class="general_item_icon_fast general_item_icon_fast_1"></i>
                    </span>
                </div>
            </div>
        </div>
    <?php } ?>
</section>