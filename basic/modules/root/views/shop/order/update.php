<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Изменить заказ: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="order-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php if($model->products) { ?>
    <div class="container-fluid view-table">
        <div class="row text-center">
            <div class="col-md-3">
                <b>Название товара</b>
            </div>
            <div class="col-md-3">
                <b>Описаниe</b>
            </div>
            <div class="col-md-1">
                <b>Цена</b>
            </div>
            <div class="col-md-1">
                <b>Кол.</b>
            </div>
            <div class="col-md-4">
                <b>Атрибуты товара</b>
            </div>
        </div>
        <?php foreach($model->products as $k): ?>
            <div class="row text-center">
                <div class="col-md-4">
                    <a class="transition_02" href="/product/<?=$k->product->seoTags->slug?>"><?= $k->product->name ?></a>
                </div>
                <div class="col-md-2">
                    <?= $k->item_price ?>
                </div>
                <div class="col-md-2">
                   <?php if($k->item_price > 0):?>
                        <?= $k->sum/$k->item_price  ?>
					<?php endif; ?>
					</div>
                <div class="col-md-4">
                    <ul>
                        <?php foreach ($k->product->productAttributesList as $key): ?>
                            <?php if ($key->value) { ?>
                                <li>
                                    <?= $key->productAttribute->name ?>
                                    <?= $key->value ?>
                                </li>
                            <?php } ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="row ">
            <div class="text-right col-md-12">
                <H3><small>Общая стоимость заказа составляет:</small> <?= $model->total ?> <i class="fa fa-rub" aria-hidden="true"></i></H3>
            </div>
        </div>
    </div>
<?php } ?>
