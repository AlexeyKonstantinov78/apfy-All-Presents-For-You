<?php
//use yii\helpers\Html;
use app\modules\shop\models\Cart;
$mod = Cart::getProductList();
$cart = Cart::getList();
$totalCost = Cart::getTotalPrice() ? Cart::getTotalPrice() : 0;
/*var_dump($totalCost);
exit;*/
?>
<section class="top_panel_element" id="cart">
    <!--
    <button type="button" class="transition_02 none_outline all_collapse" data-parent="#top_bar" data-toggle="collapse" data-target="#cart_items" >
        <img src="/img/site/icon_in_svg/cart.png" alt="Авторизация"/>
        <small>1</small>
    </button>

    <button type="button" class="transition_02 none_outline all_collapse"  >
        <img src="/img/site/icon_in_svg/cart.png" alt="Авторизация"/>
        <small>1</small>
    </button>
    -->
    <button type="button" class="transition_02 none_outline all_collapse"  data-toggle="collapse" data-target="#cart_items" >
        <img src="/img/site/icon_in_svg/cart.png" alt="Корзина"/>
        <small><?=count($mod)?></small>
    </button>
    <div class="collapse other_collapse " id="cart_items">
        <div class="disign_scroll" id="items">
            <?php if(!empty($mod)){ ?>
                <?php foreach($mod as $k): ?>
                    <section class="cart_item_id_<?=$k->id?>  item cart_element" data-id="<?=$k->id?>">
                        <div class="container-fluid">
                            <div class="row">
                                <?php if(!empty($k->mainimage)){ ?>
                                    <div class="col-sm-4">
                                        <img src="<?=$k->mainimage->thumb(null, 62)?>" alt="<?=$k->name?>" class="row"/>
                                    </div>
                                    <div class="col-sm-8">
                                <?php } else { ?>
                                    <div class="col-sm-12">
                                <?php } ?>

                                    <a href="/product/<?=$k->seoTags->slug?>" target="_blank" class="item_href transition_02" title="<?=!empty($k->seoTags->h1) ? $k->seoTags->h1 : $k->name?>">
                                        <?=!empty($k->seoTags->h1) ? $k->seoTags->h1 : $k->name?>
                                    </a>
                                    <div class="cart_item_price">
                                        <span class="item_change_quant quant_remove_to transition_02" data-id="<?=$k->id?>" data-action="remove"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>
                                        <span class="cart_item_quant"><?=$cart[$k->id]['quantity']?></span>
                                        <span class="item_change_quant quant_add_to transition_02" data-id="<?=$k->id?>" data-action="add"><i class="fa fa-plus-circle" aria-hidden="true"></i></span> X <span class="item_price"><?=number_format($k->price,0,'',' ')?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="cart_item_delete item_del_all fa fa-times-circle transition_02" aria-hidden="true" data-id="<?=$k->id?>"></span>
                    </section>
                <?php endforeach; ?>
            <?php } ?>

<!--            <section id="cart_item_id_13" data-id="13" class="item cart_element">-->
<!--                <div class="container-fluid">-->
<!--                    <div class="row">-->
<!--                        <div class="col-sm-4">-->
<!--                            <img src="https://apfy.ru/_uploads/tovarnyj_klassifikator/Nozhi_Victorinox/Perochinnye_nozhi/Multituly/SwissTool_3.0339.L/3.0339.L-1-4b0761.jpg" class="row"/>-->
<!--                        </div>-->
<!--                        <div class="col-sm-8">-->
<!--                            <a href="#" class="item_href transition_02" title="Нож перочинный Victorinox LE2017 Huntsman Year of the Rooster (1.3714.E6) 91 мм 16 функций красный">-->
<!--                            Нож перочинный Victorinox LE2017 Huntsman Year of the Rooster (1.3714.E6) 91 мм 16 функций красный-->
<!--                            </a>-->
<!--                            <div class="cart_item_price">-->
<!--                                <span class="cart_item_quant">1</span> X <span class="item_price">76900</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <span class="cart_item_delete" onclick="deleteItemCarts(id)"><img class="transition_02" src="/img/site/icons/close.svg" style="width: 17px;-->
<!--    height: 17px;"></span>-->
<!--            </section>-->
        </div>
        <div class="total_cost text-left cart_element cart_element_visible <?php if(!empty($mod)){ echo 'in'; }?>">
            Итого: <span id="total_price" class="pull-right total_price"><?=number_format($totalCost,0,'',' ')?></span>
        </div>
        <a href="/shop/cart/list" class="button_order transition_02 cart_element_visible <?php if(!empty($mod)){ echo 'in'; }?>">Оформить заказ</a>
        <section id="cart_message" class="cart_element cart_element_visible <?php if(empty($mod)){ echo 'in'; }?>">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                                <span class="transition_02" >
                                    Корзина Пуста
                                </span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
