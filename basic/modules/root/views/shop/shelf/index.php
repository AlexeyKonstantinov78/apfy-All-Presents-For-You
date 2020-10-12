<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\root\models\ShelfSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shelf';
$this->params['breadcrumbs'][] = $this->title;
$jsProduct = <<<JS
$(document).ready(function(){
	$('#findProducts').on('click', function(){
        $('#searchProductsResults').html('');
        $.post( '/root/shop/shelf/product_find', { query: $('#searchProductInput').val() }, function( data ) {
            $('#searchProductsResults').html(data);
        })
    });
    $('#searchProductsResults').on('click', 'button', function(){
        $('#mainProductChoosing').val($(this).data('id'));
        $('#searchProductsResults').html('');
    })
})
JS;
$this->registerJs($jsProduct);
?>
<div class="shelf-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-inline">
                <div class="form-group">
                    <label class="control-label" for="searchProductInput" style="margin-right: 10px" >Поиск товаров для полки (Нажимать только на кнопку найти!): </label>
                    <div class="input-group">
                        <input type="text" id="searchProductInput" class="form-control" name="products" placeholder="Поиск продуктов" maxlength="48" aria-required="true" >
                        <span class="input-group-btn"><button type="button" id="findProducts" class="btn btn-default">Найти</button></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <h3 style="margin: 0">Результат поиска</h3>
            <ul id="searchProductsResults" style="height:300px; overflow-y: scroll;">
            </ul>
        </div>
    </div>
    <p>
        <?= Html::a('Create Shelf', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
