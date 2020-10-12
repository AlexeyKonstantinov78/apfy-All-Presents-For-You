<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'История заказов';
//var_dump($model->products[0]->product->artid); exit;
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
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="/cabinet/orderhistory" itemprop="item">
                    <span itemprop="name">Мои заказы</span>
                </a>
                <meta itemprop="position" content="3">
                <span class="itemSeparator">/</span>
            </li>
            <li class="active">
                <span>
                    <span itemprop="name">Заказ № <?=$model->id?></span>
                </span>
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <section class="col-xs-12 text-center">
        <h2 class="h2" itemprop="name">Заказа № <?=$model->id?></h2>
        <hr class="gold_hr" style="margin-top: 15px; margin-bottom: 15px">
    </section>
</div>
<div class="row history-view">
    <div class="col-xs-12">
        <h3 class="h2">Подробности заказа!</h3>
        <hr class="gold_hr" style="margin-top: 10px; margin-bottom: 10px">

        <div class="container-fluid history-view_table">
            <div class="row text-left">
                <div class="col-xs-6 history-view_details">
                    <b>Дата заказа</b> -
                    <span>
                        <?=date("d.m.Y", strtotime($model->date_create));?>
                    </span>
                </div>
                <div class="col-xs-6 history-view_details">
                    <b>Адрес:</b>
                    <span>
                        <?php
                            if($model->town){
                                echo 'Город ' . $model->town . ', ';
                            }
                            if($model->street){
                                echo 'Улица ' . $model->street . ', ';
                            }
                            if($model->house){
                                echo 'Дом ' . $model->house . ', ';
                            }
                            if($model->corps){
                                echo 'Корпус ' . $model->corps . ', ';
                            }
                            if($model->entrance){
                                echo 'Подъезд ' . $model->entrance . ', ';
                            }
                            if($model->apartment){
                                echo 'Квартира ' . $model->apartment . ', ';
                            }
                            if($model->floor){
                                echo 'Этаж ' . $model->floor . ', ';
                            }
                        ?>
                    </span>
                </div>
            </div>
            <div class="row text-left">
                <div class="col-xs-6 history-view_details">
                    <b>Способ доставки</b> -
                    <span>
                        <?=$model->getNameDelivery($model->delivery);?>
                        <?=$model->getNameDeliveryCh($model->delivery_choose);?>,
                    </span>
                </div>
                <div class="col-xs-6 history-view_details">
                    <b>Статус заказа</b> - <label><?=$model->getNameStatus($model->status);?></label>
                </div>
            </div>
            <div class="row text-left">
                <div class="col-xs-6 history-view_details">
                    <b>Цена доставки</b> -
                    <span>
                        <?= number_format($model->delivery_price,0,'',' ') ?>
                        <i class="fa fa-rub" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="col-xs-6 history-view_details">
                    <b>Общая сумма</b> -
                    <span>
                        <?= number_format($model->total,0,'',' ') ?>
                        <i class="fa fa-rub" aria-hidden="true"></i>
                    </span>
                </div>
            </div>
        </div>

        <h3 class="h2">Товары заказа</h3>
        <hr class="gold_hr" style="margin-top: 10px; margin-bottom: 15px">
        <?php if($model->products) { ?>
            <div class="container-fluid history-view_table">
                <div class="row text-left history-view_td-th">
                    <div class="col-xs-4">
                        <b>Название товара</b>
                    </div>
                    <div class="col-xs-3">
                        <b>Цена</b>
                    </div>
                    <div class="col-xs-2">
                        <b>Кол.</b>
                    </div>
                    <div class="col-xs-3">
                        <b>Акртикул</b>
                    </div>
                </div>
                <?php foreach($model->products as $k): ?>
                    <div class="row text-left history-view_td">
                        <div class="col-xs-4">
                            <?= $k->product->name ?>
                        </div>
                        <div class="col-xs-3">
                            <?= number_format($k->item_price,0,'',' ') ?>
                            <i class="fa fa-rub" aria-hidden="true"></i>
                        </div>
                        <div class="col-xs-2">
                            <?php if($k->item_price > 0):?>
                                <?= $k->sum/$k->item_price  ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-3">
                            <?php if($k->product->artid):?>
                                <?= $k->product->artid ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="row ">
                    <div class="text-right col-md-12">
                        <h4>
                            <small>Общая стоимость заказа составляет:</small>
                            <?= number_format($model->total,0,'',' ') ?>
                            <i class="fa fa-rub" aria-hidden="true"></i>
                        </h4>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>