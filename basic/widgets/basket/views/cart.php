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
<section class="top_panel_element" id="cart">
    <button type="button" class="" data-toggle="collapse" data-target="#cart_items" aria-expanded="false" aria-controls="cart_items">
        <img src="/img/site/icon_in_svg/cart.png" alt="Авторизация"/>
    </button>

</section>
