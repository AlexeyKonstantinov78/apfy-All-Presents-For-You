<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'История заказов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12">
        <ul id="breadcrumbs" style="
            border-bottom: 1px solid #f3eccd;
        " itemscope="" itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="/" itemprop="item">
                    <span itemprop="name">Главная</span>
                </a>
                <meta itemprop="position" content="1">
                <span class="itemSeparator">/</span>
            </li>
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="/cabinet/" itemprop="item">
                    <span itemprop="name">Профиль</span>
                </a>
                <meta itemprop="position" content="2">
                <span class="itemSeparator">/</span>
            </li>
            <li class="active">
                <span>
                    <span itemprop="name">Мои заказы</span>
                </span>
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <section class="col-xs-12 text-center">
        <h2 class="h2" itemprop="name">Мои заказы</h2>
        <hr class="gold_hr" style="margin-top: 15px; margin-bottom: 15px">
    </section>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php
        echo yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            //'tableOptions' => ['id' => 'history-table', 'class' => 'table table-striped table-bordered'],
            'tableOptions' => ['id' => 'history-table', 'class' => 'table table-striped'],
            'headerRowOptions' => ['class'=>'history-column_header',],
            'rowOptions' => ['class' => 'history-column transition_02'],
            'columns' => [
                [
                    'attribute'=>'date_create',
                    'label'=>'Дата',
                    'format' => ['date', 'd.m.Y'],
                    'contentOptions' => ['class' => 'text-right history-column_date'],
                    'headerOptions' => ['class'=>'text-right',],
                ],
                [
                    'attribute'=>'id',
                    'label'=>'Номер',
                    'contentOptions' => ['class' => 'text-right history-column_id'],
                    'headerOptions' => ['class'=>'text-right',],
                ],
                [
                    'attribute'=>'total',
                    'label'=>'Сумма',
                    'format'=> ['decimal',0],
                    'contentOptions' => ['class' => 'text-right history-column_total'],
                    'headerOptions' => ['class'=>'text-right',],
                ],
                [
                    'label'=>'Статус',
                    'attribute' => 'status',
                    'format' => 'text',
                    'content'=>function($data){
                        return $data->getNameStatus($data->status);
                    },
                    'contentOptions' => ['class' => 'text-right history-column_status'],
                    'headerOptions' => ['class'=>'text-right',],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'',
                    'headerOptions' => ['width' => '80'],
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url,$model) {
                            return Html::a(
                            'Подробнее...',
                                $url,
                                ['class' => 'transition_02 black_purpule_a']
                            );
                        },
                    ],
                    'contentOptions' => ['class' => 'text-right history-column_action'],
                    'headerOptions' => ['class'=>'text-right',],
                ],
            ],
        ]);
        ?>
        <div class="pagination-container pagination_dis text-center">
            <?=yii\widgets\LinkPager::widget(array(
                'pagination' => $dataProvider->pagination,
                'prevPageLabel'=>'<i class="fa fa-angle-left transition_02" aria-hidden="true"></i>',
                'nextPageLabel'=>'<i class="fa fa-angle-right transition_02" aria-hidden="true"></i>',
            ));?>
        </div>
    </div>
</div>