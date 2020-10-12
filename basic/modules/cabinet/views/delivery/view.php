<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">


    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'email:email',
            'phone',
            'town',
            'street',
            'house',
            'corps',
            'apartment',
            'entrance',
            'floor',
            'terms_of_use',
            'comment',
            'total',
            [
                'attribute' => 'status',
                'value' => $model->getNameStatus($model->status),
            ],
            [
                'attribute' => 'date_create',
                'format' =>  ['date', 'HH:mm dd.MM.YYYY'],
                'options' => ['width' => '200']
            ],
            [
                'attribute' => 'date_edit',
                'format' =>  ['date', 'HH:mm dd.MM.YYYY'],
                'options' => ['width' => '200']
            ],
        ],
    ]) ?>
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
               
            </div>
            <?php foreach($model->products as $k): ?>
		
                <div class="row text-center">
                    <div class="col-md-3">
                        <?= $k->product->name ?>
                    </div>
                    <div class="col-md-1">
                        <?= $k->item_price ?>
                    </div>
					<div class="col-md-1">
                   <?php if($k->item_price > 0):?>
                        <?= $k->sum/$k->item_price  ?>
					<?php endif; ?>
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
</div>
