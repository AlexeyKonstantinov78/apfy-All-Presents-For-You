<?php
//use yii\helpers\Html;
use app\modules\shop\models\Cart;
use yii\bootstrap\Modal;
$mod = Cart::getProductList();
$cart = Cart::getList();
$totalCost = Cart::getTotalPrice() ? Cart::getTotalPrice() : 0;
/*var_dump($totalCost);
exit;*/
?>

<div class="notification pos-right pos-top  cart-overview" data-notification-link="cart-overview" data-animation="from-right">
    <?php if(!empty($mod)){ ?>
        <div class="cart-overview__title">
            <h5 class="padding_basket">Ваш заказ:</h5>
        </div>
        <ul class="cart-overview__items padding_basket" id="basket">
                <!--Example list items-->
                <!--li>
                    <div class="item__image">
                        <a href="#">
                            <img alt="product" src="/img/tmp/product-small-1.png" />
                        </a>
                    </div>
                    <div class="item__detail">
                        <span>Dave Wool Beanie</span>
                        <span class="h6">1 x $39.00</span>
                    </div>
                    <div class="item__remove" title="Remove From Cart"></div>
                </li>
                <!--Example list items end-->
            <?php foreach($mod as $k): ?>
                <li id="id_prod_<?=$k->id?>" data-id="<?=$k->id?>" class="display_table">
                    <div class="item__image  display_table_cell vertical_middle" style="background-image: url(<?=$k->mainimage->thumb(null, 78)?>)">
                        <a href="#">
                            <img alt="product" src="<?=$k->mainimage->thumb(null, 78)?>" />
                        </a>
                    </div>
                    <div class="item__detail  display_table_cell vertical_middle">
                        <a href="/product/<?=$k->seoTags->slug?>"><span class="transition_leaner_02"><?=$k->name?></span></a>
                        <span class="h6"><span class="quantity_item"><?=$cart[$k->id]['quantity']?></span> x <?=$k->price?> руб.</span>
                    </div>
                    <div class="item__remove del_item" title="Удалить товар" data-id="<?=$k->id?>"></div>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="cart-overview__subtotal padding_basket">
            <h5>Итоговая цена:</h5>
            <span><span class="total_cost"><?=$totalCost?></span> руб.</span>
        </div>
        <div class="cart-overview__action padding_basket">
            <span class="btn btn--square btn--primary nav-icon-basket">
                <a href="/shop/cart/list">
                    <span class="btn__text">
                        Сделать заказ
                    </span>
                </a>
            </span>
        </div>
    <?php } else { ?>
        <div class="cart-overview__title">
            <h5 class="padding_basket">Ваша корзина пуста!</h5>
        </div>
        <div class="display_nonee">
            <ul class="cart-overview__items padding_basket" id="basket">
                <!--Example list items-->
                <!--li>
                    <div class="item__image">
                        <a href="#">
                            <img alt="product" src="/img/tmp/product-small-1.png" />
                        </a>
                    </div>
                    <div class="item__detail">
                        <a href="#"><span class="transition_leaner_02">Dave Wool Beanie</span></a>
                        <span class="h6">1 x $39.00</span>
                    </div>
                    <div class="item__remove" title="Remove From Cart"></div>
                </li>
                <!--Example list items end-->
                <!--Example list items for jq-->
                <!--li><div class="item__image"><a href="#"><img alt="product" src="/img/tmp/product-small-1.png" /></a></div><div class="item__detail"><span>Dave Wool Beanie</span><span class="h6">1 x $39.00</span></div><div class="item__remove" title="Remove From Cart"></div></li>
                <!--Example list items end-->
            </ul>
            <div class="cart-overview__subtotal padding_basket">
                <h5>Итоговая цена:</h5>
                <span class="total_cost"><?=$totalCost?> руб.</span>
            </div>
            <div class="cart-overview__action padding_basket">
            <span class="btn btn--square btn--primary nav-icon-basket">
                <a href="/shop/cart/list">
                    <span class="btn__text">
                        Сделать заказ
                    </span>
                </a>
            </span>
            </div>
        </div>
    <?php } ?>
    <div class="notification-close-cross notification-close"></div>
</div>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeaderCallback'],
    'id' => 'callback',
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalCallback'></div>";
yii\bootstrap\Modal::end();
?>