<?php
use app\helpers\Image;
//var_dump($models); exit;
$js = <<<JS
$(document).ready( function(){
    function querysend(ob){
        var query = ob.find("input[type=text]").val();
        query = query.trim();
    
            location.href = '/search/'+encodeURIComponent(query)+'';
        return false;
    }
    $(".searchings").on("submit", function(){
        return querysend($(this));
    })
});
JS;
$this->registerJs($js);
?>
<style>
.artid {
	font-size: 12px;
	display: inline-block;
	position: absolute;
	top: -10px;
    right: 15px;
	font-weight: 600;
}
</style>
<main class="container" id="search_page">

    <div class="row">
        <div class="col-xs-12 text-center">
            <hr class="gold_hr"/>
            <h1 class="h2 header_light h_gold text-uppercase">Поиск</h1>
        </div>
    </div>
    <div class="input_panel row clear">
        <form name="search" class=" searchings input_panel_section" action="/search/">
            <div class="input-group col-xs-12">
                <input type="text" class="black_white_form form-control none_outline transition_02" name="text" value="<?=\Yii::$app->request->get('query')?>" placeholder="Поиск..." />
                <button class="input-group-addon item_quant black_white_form  transition_02" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </form>
    </div>
    <?php if(!is_null($models) && count($models)>0): ?>
        <section class="row">
            <div class="col-xs-12 text-center text-uppercase">
                <span class="header_filtres" style="font-size: 15px">Найдено товаров по запросу "<?=\Yii::$app->request->get('query')?>" - <b style="color:#000; margin-left: 10px; display: inline-block"><?=count($models)?></b></span>
            </div>

            <?php foreach ($models as $k=>$v){ ?>
                <?php //var_dump($v['highlight']['name'][0]); exit; ?>
                <?php $v['highlight']['name'] = !empty($v['highlight']) ? $v['highlight']['name'][0] : $v['_source']['name']; ?>
                <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12">
                    <div class="general_item  transition_02">
						<em class="artid" style="color:red">Артикул <?=$v['_source']['artid']?></em>
                        <?php if(!empty($v['_source']['discount_price']) && $v['_source']['discount_price']>0) : ?>
                            <?php if($v['_source']['discount_price'] > 555000): ?>
                                <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
                            <?php endif; ?>
                        <?php elseif ($v['_source']['price'] > 5000): ?>
                            <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
                        <?php endif; ?>
                        <?php if($v['_source']['image'] != null) { ?>
                            <a href="/product/<?=$v['_source']['slug']?>" title="<?=$v['_source']['name']?>" class="text-center general_item_img">
                                <img alt="<?=$v['_source']['name']?>"
                                     src="<?=Image::thumb($v['_source']['image'], null, 260)?>">
                            </a>
                        <?php } ?>
                        <?php if($v['_source']['active'] == 1): ?>
                            <span class="item_stock_11 item_stock clearfix"><!--В наличии--></span>
                        <?php else: ?>
                            <span class="item_stock_21 item_stock clearfix"><!--Под заказ--></span>
                        <?php endif; ?>
                        <div class="general_item_desc">
                            <a class="transition_02" href="/product/<?=$v['_source']['slug']?>"
                               title="<?=$v['_source']['name']?>"><?=$v['highlight']['name']?></a>
                        </div>
                        <hr class="gold_hr"/>
                        <?php if(!empty($v['_source']['discount_price']) && $v['_source']['discount_price']>0): ?>
                            <span class="general_item_price general_item_price_dis" data-price="<?=$v['_source']['discount_price']?>">
                                <?=number_format($v['_source']['discount_price'],0,'',' ');?>
                                <span class="general_item_currency">руб.</span>
                            </span>
                            <span class="general_item_price_discount">
                                <?=number_format($v['_source']['price'],0,'',' ');?>
                                <span class="general_item_currency">руб.</span>
                            </span>
                        <?php else: ?>
                            <span class="general_item_price" data-price="<?=$v['_source']['price']?>">
                                <?=number_format($v['_source']['price'],0,'',' ');?>
                                <span class="general_item_currency">руб.</span>
                            </span>
                        <?php endif; ?>
                        <div class="general_add">
                            <?php if($v['_source']['active'] == 1): ?>
                                <span class="general_item_pay add_to_cart red_but
                                        transition_02 hover_opaticy" data-id="<?=$v['_source']['product_id']?>" data-href="/product/<?=$v['_source']['slug']?>">Добавить в корзину</span>
                                <span class="general_item_order_fast general_item_icon hover_opaticy"  data-id="<?=$v['_source']['product_id']?>" data-toggle="tooltip"  title="Купить в один клик" >
                                            <i class="general_item_icon_fast general_item_icon_fast_1"></i>
                                        </span>
                            <?php else: ?>
                                <span class="general_item_order_under red_but
                                        transition_02 hover_opaticy" data-id="<?=$v['_source']['product_id']?>" data-href="/product/<?=$v['_source']['slug']?>">Под заказ</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </section>
    <?php else: ?>
        <section class="row">
            <div class="col-xs-12 text-center text-uppercase">
                <span class="header_filtres" style="font-size: 18px; font-weight: bold; margin-top: 30px">Введите запрос для поиска!</span>
            </div>
        </section>
    <?php endif; ?>
</main>
