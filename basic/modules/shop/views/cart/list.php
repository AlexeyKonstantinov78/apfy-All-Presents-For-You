<?php
use app\modules\shop\models\Cart;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\FancyAsset;
use app\widgets\cdek\CdekWidget;
FancyAsset::register($this);
$totalCost = Cart::getTotalPrice() ? Cart::getTotalPrice() : 0;
$js = <<<JS
$('.fancy_a').fancybox({
    type: 'ajax'
})
  

JS;

$this->registerJs($js);
?>
<div class="container">
    <div class="row">
        <div id="breadcrumbs" class="col-xs-12" style="border-bottom: 1px solid #f3eccd;"><a href="/">Главная</a> <span>/</span>Корзина</div>
    </div>
</div>
<main class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <hr class="gold_hr" style="margin-bottom: 26px">
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
            <?php foreach($model as $p):?>
                <div class="col-xs-12 order_item cart_item_id_<?=$p->id?>">
                    <div class="col-sm-3 col-xs-4 order_item_img text-center">
                        <img src="<?=$p->mainimage->thumb(150)?>" alt="<?=$p->name?>">
                    </div>
                    <div class="col-sm-9 col-xs-8">
                        <div class="row order_item_desc">
                            <div class="col-md-9 col-sm-8 col-xs-12 order_item_name">
                                <a target="_blank" href="/product/<?=$p->seoTags->slug?>" class="transition_02"><?=$p->name?></a>
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
                                <section class="input-group col-lg-5 col-md-6 col-sm-9 col-xs-12">
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
            <div class="col-xs-12 order_item order_item_price_b">
                <div class="row">
                    <div class="col-xs-6 col-md-9 col-sm-4 text-right">
                        <span>Итог:</span>
                    </div>
                    <div class="col-xs-6 col-md-3 col-sm-8 text-right">
                        <b><span class="item_price_number total_price"><?=number_format($totalCost,0,'',' ')?></span> руб.</b>
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <?= CdekWidget::widget() //если нет with_id, то действует выбирает по with_ParentId (parent_id) ?>
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
                        ])->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <?= $form->field($order, 'email', [
                            'options' => ['class' => 'form-group'],
                        ])->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-xs-12 hidden-md"></div>
                    <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                        <?= $form->field($order, 'town', [
                            'options' => ['class' => 'form-group'],
                        ])->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                        <?= $form->field($order, 'street', [
                            'options' => ['class' => 'form-group'],
                        ])->textInput(['maxlength' => true]) ?>
                    </div>

                    <div class="col-xs-12 hidden-lg hidden-md hidden-xs"></div>

                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-6">
                        <?= $form->field($order, 'house', [
                            'options' => ['class' => 'form-group'],
                        ])->textInput(['maxlength' => true]) ?>
                    </div>

                    <div class="col-xs-12 hidden-lg hidden-sm"></div>

                    <div class="col-lg-1 col-md-3 col-sm-2 col-xs-6">
                        <?= $form->field($order, 'corps', [
                            'options' => ['class' => 'form-group'],
                        ])->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-lg-1 col-md-3 col-sm-2 col-xs-6">
                        <?= $form->field($order, 'apartment', [
                            'options' => ['class' => 'form-group'],
                        ])->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-lg-1 col-md-3 col-sm-2 col-xs-6">
                        <?= $form->field($order, 'entrance', [
                            'options' => ['class' => 'form-group'],
                        ])->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-lg-1 col-md-3 col-sm-2 col-xs-6">
                        <?= $form->field($order, 'floor', [
                            'options' => ['class' => 'form-group'],
                        ])->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-xs-12"></div>
                    <div class="col-sm-6 col-xs-12">
                        <?= $form->field($order, 'terms_of_use',
                            [
                                'template' => "
                                    <label>\n{input} 
                                        <span class='terms_of_use'>Я прочитал и согласен с условиями 
                                            <a class='fancy_a transition_02' href='/page/polzovatelskoe-soglashenie' >пользовательского соглашения</a> 
                                            и <a class='fancy_a transition_02' href='/page/politika-konfidencialnosti'>политики конфиденциальности</a>.
                                            
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
                            <?= Html::submitButton('Оформить', ['class' => 'btn btn-block black_white_form transition_02 black_el']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </section>
    <?php endif;?>
</main>
