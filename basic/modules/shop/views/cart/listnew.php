<?php

use app\modules\shop\models\Cart;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use app\assets\FancyAsset;
use app\widgets\cdek\CdekWidget;
FancyAsset::register($this);
$totalCost = Cart::getTotalPrice() ? Cart::getTotalPrice() : 0;
$totalDelivery = $totalCost<4000 ? 350 : 0;
$quantCdek = 0;
$js = <<<JS
$('.fancy_a').fancybox({
    type: 'ajax'
})
/*
$('button.halvaItems').on('click', function(){
    $('.halvaItemsDesc').toggle('slow');
});
//*/

JS;

$this->registerJs($js);
$this->registerCssFile('/css/site/pagesCss/category.css');
?>

<script>var objCdek = [];</script>
<div class="container">
    <div class="row">
		<div class="col-xs-12">
			<ul id="breadcrumbs" style="border-bottom: 1px solid #f3eccd;" itemscope="" itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
					<a href="/" itemprop="item"><span itemprop="name">Главная</span></a><meta itemprop="position" content="1"><span class="itemSeparator">/</span>
				</li>
				<li class="active"><span><span itemprop="name">Корзина</span></span></li>
			</ul> 
		</div>
    </div>
</div>
<main class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <hr class="gold_hr" >
            <h1 class="h2 header_light h_gold ">Корзина</h1>
        </div>
    </div>
    <section class="row empty_order <?php if($model == null) echo 'in'; ?> ">
        <div class="col-xs-12">
            <p class="text-center"><i class="fa fa-shopping-cart" aria-hidden="true"></i></p>
            <p class="text-uppercase text-center" style="font-size: 18px">В ВАШЕЙ КОРЗИНЕ НЕТ ТОВАРОВ</p>
            <p class="text-center">Чтобы добавить товары в корзину, воспользуйтесь <a class="transition_02 purpule_gold_a" href="/category/katalog">каталогом нашего магазина</a></p>
        </div>
    </section>
    <?php if($model !== null): ?>
        <section id="order_list" class="row">
            <div class="col-md-8 col-xs-12">
                <div class="row">
                    <script>var d=0; </script>
                    <?php foreach($model as $p):?>
                        <?php
//                        echo (float)$p->scope*(int)$cart[$p->id]['quantity'].'<br/>';
//                        echo (int)$cart[$p->id]['quantity'].'<br/>';
//                        echo (float)$p->scope.'<br/>';
//                        exit;
                        ?>
                        <script>
                            var scope = Math.cbrt(Number(<?=(float)$p->scope*(float)$cart[$p->id]['quantity']?>));
                            var wieght = Number(<?=(float)$p->weight*(float)$cart[$p->id]['quantity']?>);
                            var scopeZero = <?=(float)$p->scope?>;
                            var wieghtZero = Number(<?=(float)$p->weight?>);
                            objCdek[d] = {
                                lengths: scope,
                                width: scope,
                                height: scope,
                                weight: wieght,
                                quant: <?=(float)$cart[$p->id]['quantity']?>,
                                s:scope,
                                w:wieght,
                                sZero:scopeZero,
                                wZero:wieghtZero,
                                id: <?=$p->id?>
                            };
                            //console.log(objCdek);
                            d++;
                        </script>
                        <?php $quantCdek = $quantCdek + $cart[$p->id]['quantity']?>
                        <div class="col-xs-12 order_item cart_item_id_<?=$p->id?>">
                            <div class="col-sm-3 col-xs-4 order_item_img text-center">
                                <img src="<?=$p->mainimage->thumb(150)?>" alt="<?=$p->name?>">
                            </div>
                            <div class="col-sm-9 col-xs-8">
                                <div class="row order_item_desc">
                                    <div class="col-md-9 col-sm-8 col-xs-12 order_item_name">
                                        <a target="_blank" href="/product/<?=$p->seoTags->slug?>" class="transition_02"><?=!empty($p->seoTags->h1) ? $p->seoTags->h1 : $p->name?></a>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12 order_item_price">
                                        <?php if(!empty($p->discount_price) && $p->discount_price>0) $p->price = $p->discount_price; ?>
                                        <span class="order_item_price_b"><?=number_format($p->price,0,'',' ');?></span> руб.
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9 col-xs-12">
                                <div class="row  order_item_control">
                                    <div class="col-md-9 col-sm-8 col-xs-6 order_item_quant">
                                        <section class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label class="hidden-xs input-group-addon black_white_form">Количество</label>
                                            <span class="input-group-addon item_change_quant quant_remove_to black_white_form white_el transition_02" data-id="<?=$p->id?>" data-action="delete">-</span>
                                            <input
                                                    class="text-center cart_item_quant_input none_outline form-control black_white_form"
                                                    type="text"
                                                    name="item_quant"
                                                    placeholder="<?=$cart[$p->id]['quantity']?>"
                                                    value="<?=$cart[$p->id]['quantity']?>"
                                                    data-weight="<?=$p->weight?>"
                                                    data-scope="<?=$p->scope?>"
                                                    data-id="<?=$p->id?>"
                                            >
                                            <span class="input-group-addon item_change_quant quant_add_to black_white_form white_el transition_02" data-id="<?=$p->id?>" data-action="add">+</span>
                                        </section>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-6">
                                        <span class="order_item_delete item_del_all order_grey fa fa-times-circle transition_02" aria-hidden="true" data-id="<?=$p->id?>"> Удалить из корзины</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="col-md-4 col-xs-12" id="orderRight" style="margin-top: 40px">
                <div class="row">
                    <div class="col-xs-12  ">
                        <div class="row">
                            <div class="col-xs-6 col-md-6 col-sm-4 text-right">
                                <span>Доставка:</span>
                            </div>
                            <div class="col-xs-6 col-md-6 col-sm-8 text-right">
                                <b>+ <span class="item_price_number delivery_price"><?=number_format($totalDelivery,0,'',' ')?></span> руб.</b>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12  ">
                        <div class="row">
                            <div class="col-xs-6 col-md-6 col-sm-4 text-right" >
                                <span>Товаров:</span>
                            </div>
                            <div class="col-xs-6 col-md-6 col-sm-8 text-right">
                                <b>+ <span class="item_price_number total_price"><?=number_format($totalCost,0,'',' ')?></span> руб.</b>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 order_item order_item_price_b" style="padding-top: 20px; border-top:4px solid #efefef; border-bottom: none !important;">
                        <div class="row">
                            <div class="col-xs-6 col-md-6 col-sm-4 text-right">
                                <span>Итог:</span>
                            </div>
                            <div class="col-xs-6 col-md-6 col-sm-8 text-right">
                                <b><span class="item_price_number total_price item_price_number_new" data-total="<?=number_format($totalCost,0,'',' ')?>">
                                        <?=number_format($totalCost + $totalDelivery,0,'',' ')?>
                                    </span> руб.</b>
                            </div>
							<div class="col-xs-12 text-center" style="margin-top: 30px; height: 70px">
								<button class="halvaItems none_outline" style="cursor: default; margin: 0 10px 5px 0; float: left"><img src="/img/site/halva/order_product/toggle.jpg" alt="Рассрочка 4 месяца по крарте Халвы!" /></button>
								<div class="halvaItemsDesc" style="display:block">
									<p>4 месяца рассрочки без переплаты для владельцев карты Халва! <a href="/page/karta-halva" class="fancy_a transition_02">Побробнее...</a></p>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <?php $form = ActiveForm::begin([
                    //'ajaxParam'=>'ajax',
                    //'enableAjaxValidation'=>true,
                    'options' => [
                        'class' => 'row',
                        'id' => 'form_order'
                    ]

                ]); ?>
                <h4 class="h1 col-xs-12 text-center" style="margin-bottom: 30px">Оформление заказа</h4>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <?= $form->field($order, 'name', [
                        'options' => ['class' => 'form-group'],
                    ])->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                    <?= $form->field($order, 'phone', [
                        'options' => ['class' => 'form-group'],
                    ])->widget(\yii\widgets\MaskedInput::className(), [
                        'mask' => '+7(999)-999-99-99',
                    ])?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <?= $form->field($order, 'email', [
                        'options' => ['class' => 'form-group'],
                    ])->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12">
                            <?=$form->field($order, 'delivery')->dropDownList([
                                '1' => 'Транспортной Компанией СДЭК',
                                '0' => 'Доставка силами APFY.RU (Только по Москве. Подмосковье +100 руб. за каждые 10 км.) ',
                            ]); ?>
                        </div>
                        <div class="col-xs-12 choose_delivery choose_delivery_apfy delivery_active">
                            <p>Бесплатно при заказе от 4000 руб.</p>
                        </div>
                        <div class="col-xs-12 choose_delivery choose_delivery_cdek ">
                            <p>При заказе от 10000 руб. доставку СДЭК мы оплатим за Вас. В стоимость заказа она не включается.</p>
                            <p><b>Стоимость доставки рассчитывается автоматически согласно тарифам СДЭК и исходя из объема и веса заказа.</b></p>
                            <p>На карте укажите город и способ доставки (курьерская до дверей или до пункта самовывоза).</p>
                            <p><b>Для корректного расчета стоимости доставки при самовывозе на карте нажмите кнопку "Выбрать" под описанием выбранного Вами Пункта Выдачи Заказов (ПВЗ).</b></p>
                            <p style="font-size: 14px;"><b>Обратите внимание</b> - при доставке ТК СДЭК карта рассрочки Халва принимается только при онлайн-оплате заказа на сайте.</p>
                            <?= CdekWidget::widget() //если нет with_id, то действует выбирает по with_ParentId (parent_id) ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                    <?= $form->field($order, 'town', [
                        'options' => ['class' => 'form-group clear_input'],
                    ])->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                    <?= $form->field($order, 'street', [
                        'options' => ['class' => 'form-group clear_input'],
                    ])->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-xs-12 hidden-lg hidden-md hidden-xs"></div>

                <div class="col-lg-1 col-md-3 col-sm-4 col-xs-6">
                    <?= $form->field($order, 'house', [
                        'options' => ['class' => 'form-group clear_input'],
                    ])->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-xs-12" style="display: none">
                    <?= $form->field($order, 'delivery_price', [
                        'options' => ['class' => 'form-group'],
                    ])->hiddenInput(['value' => $totalDelivery]) ?>
                    <?= $form->field($order, 'delivery_choose', [
                        'options' => ['class' => 'form-group'],
                    ])->hiddenInput(['value' => '1']) ?>
                </div>

                <div class="col-lg-1 col-md-3 col-sm-2 col-xs-6">
                    <?= $form->field($order, 'corps', [
                        'options' => ['class' => 'form-group clear_input'],
                    ])->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-1 col-md-3 col-sm-2 col-xs-6">
                    <?= $form->field($order, 'apartment', [
                        'options' => ['class' => 'form-group clear_input'],
                    ])->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-1 col-md-3 col-sm-2 col-xs-6">
                    <?= $form->field($order, 'entrance', [
                        'options' => ['class' => 'form-group clear_input'],
                    ])->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-1 col-md-3 col-sm-2 col-xs-6">
                    <?= $form->field($order, 'floor', [
                        'options' => ['class' => 'form-group clear_input'],
                    ])->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-xs-12">
                    <?= $form->field($order, 'comment_more', [
                        'options' => ['class' => 'form-group clear_input'],
                    ])->textArea(['maxlength' => true]) ?>
                </div>
                <div class="col-xs-12">
                    <?php if(!isset($_GET['deb'])): ?>
                        <?=$form->field($order, 'payment_choose')->dropDownList([
                            '0' => 'Наличными при получении',
                            '1' => 'Банковской картой при получении',
                            '2' => 'Онлайн оплата',

                            //
                        ]); ?>
                    <?php else: ?>
                        <?=$form->field($order, 'payment_choose')->dropDownList([
                            '0' => 'Наличными при получении',
                            //'2' => 'Онлайн оплата Сбербанк',
                            '1' => 'Банковской картой при получении',
                            '3' => 'Онлайн оплата АльфаБанк',

                            //
                        ]); ?>
                    <?php endif; ?>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <?= $form->field($order, 'terms_of_use',
                        [
                            'template' => "
                                    <label>\n{input} 
                                        <span class='terms_of_use'>Я прочитал и согласен с условиями 
                                            <a target='_blank' class='fancy_a transition_02' href='/page/polzovatelskoe-soglashenie' >пользовательского соглашения</a> 
                                            и <a target='_blank' class='fancy_a transition_02' href='/page/politika-konfidencialnosti'>политики конфиденциальности</a>.
                                            
                                        </span>
                                    </label>\n{hint}\n{error}
                                "
                        ]
                    )->checkbox([
                        'value'=>1,
                        'uncheck'=>0,
                        'checked '=>$order->terms_of_use?true:false,
                        'label'=>false,
                    ], false)?>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="form-group">
                        <?= Html::submitButton('Оформить', ['class' => 'btn btn-block black_white_form1 purpule_el gold_hover_el transition_02 black_el',]) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </section>
    <?php endif;?>
</main>

