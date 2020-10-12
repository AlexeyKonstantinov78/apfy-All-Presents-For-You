<div class="container sub_cats clearfix" style="margin-bottom: 10px">
    <div class="row">
        <?php foreach($model->children as $ch) {?>
            <?php $sub_cats[] = [
                'name' => $ch->name,
                'id' => $ch->id
            ]; ?>
            <div class="col-md-3 col-sm-6 col-xs-6 sub_cut text-center">
                <div class="sub_cuts_img">
                    <img src="<?=$ch->mainImage->thumb(240)?>" alt="<?=$ch->name?>"/>
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

<section class="row">
    <div class="col-xs-12 text-center text-uppercase"><span class="header_filtres" style="font-size: 15px">Найдено <b style="color:#000; margin-left: 10px; display: inline-block"><?=count($products)?></b></span> </div>
    <?php foreach ($products as $k=>$v){ ?>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="general_item  transition_02"
                 data-itemid="<?=$v['id']?>">
                <?php if(!empty($v['image'])) { ?>
                    <div class="text-center general_item_img">
                        <img alt="<?=$v['name']?>"
                             src="<?=Image::thumb($v['image'], null, 260);?>">
                    </div>
                <?php } ?>
                <span class="item_stock item_stock_1 clearfix">На складе</span>
                <div class="general_item_desc">
                    <a class="transition_02" href="/product/<?=$v['slug']?>"
                       title="<?=$v['name']?>"><?=$v['name']?></a>
                </div>
                <hr class="gold_hr"/>
                <span class="general_item_price" data-price="<?=$v['price']?>">
                                    <?=$v['price']?>
                    <span class="general_item_currency">руб.</span>
                                </span>
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