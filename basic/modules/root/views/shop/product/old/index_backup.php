<?php

use yii\helpers\Html;
use app\widgets\menu\MenuWidget;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <div class="row" style="margin-top: 40px">
        <div class="col-md-4 col-sm-3 col-xs-12">
            <div class="row right-filter">
                <h4 class="page-header" style="margin-top: 0">Категории товаров</h4>
                <?= MenuWidget::widget([
                    'tmp_menu' => 'filter_cat_admin',
                    'max_level' => '99',
                    'with_id' => null,
                    'with_ParentId' => '86',
                ]) ?>
            </div>
        </div>
        <div class="col-md-8 col-sm-9 col-xs-12">
            <h4 class="page-header" style="margin-top: 0">Товары</h4>
            <p>
                <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <div id="list_items">
                <?= $this->render('list_product', [
                    'dataProvider' => $dataProvider,
                ]) ?>
            </div>
        </div>
    </div>

</div>
