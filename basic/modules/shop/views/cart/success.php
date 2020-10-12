<?php
use app\modules\shop\models\Cart;
//$id = 121;
$total = Cart::getTotalPrice().'.00';
$script = <<< JS
var total = $total,
id = $id;
JS;
$this->registerJs($script,  yii\web\View::POS_HEAD);
//$this->registerJsVar('total', '2500.0', yii\web\View::POS_HEAD);
//$this->registerJsVar('id', $id, yii\web\View::POS_HEAD);
?>
<?php
Cart::flushList();
?>
<main class="container success">
    <div class="row">
        <div class="col-xs-12">
            <h1 class="text-center h1">Спасибо за заказ!</h1>
			<?php if($ok !== null): ?>
                <?php if($ok == 1): ?>
                    <p>Оплата прошла успешно</p>
                <?php else: ?>
                    <p>Сведения об оплате:</p>
                    <p><?php echo $message; ?></p>
                <?php endif; ?>
            <?php endif; ?>
            <p>Номер Вашего Заказа - <?=$id?></p>
            <p>В ближайшее время с Вами свяжется менеджер для подтверждения заказа.</p>
            <p class="text-center">
                <a href="/" class="black_white_form purpule_el gold_hover_el text-center text-uppercase transition_02 " style="width:100%">
                    Вернуться к покупкам
                </a>
            </p>
        </div>
    </div>
</main>