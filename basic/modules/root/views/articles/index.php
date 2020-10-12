<?php

use yii\helpers\Html;
use app\widgets\menu\MenuWidget;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <div class="row" style="margin-top: 40px">
        <div class="col-md-4 col-sm-3 col-xs-12">
            <div class="row right-filter">
                <h4 class="page-header" style="margin-top: 0">Категории статей</h4>
                <?= MenuWidget::widget([
                    'tmp_menu' => 'filter_cat_art_admin',
                ]) ?>
            </div>
        </div>
        <div class="col-md-8 col-sm-9 col-xs-12">
            <h4 class="page-header" style="margin-top: 0">Статьи</h4>
            <p>
                <?= Html::a('Добавить Статью', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <div id="list_items">
                <?= $this->render('list_articles', [
                    'dataProvider' => $dataProvider,
                ]) ?>
            </div>
        </div>
    </div>

</div>
