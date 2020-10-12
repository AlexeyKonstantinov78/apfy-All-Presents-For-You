<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Create Order';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
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
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="/cabinet/delivery" itemprop="item">
                    <span itemprop="name">Адрес доставки</span>
                </a>
                <meta itemprop="position" content="3">
                <span class="itemSeparator">/</span>
            </li>
            <li class="active">
                <span>
                    <span itemprop="name">Изменить адрес</span>
                </span>
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <section class="col-xs-12 text-center">
        <h2 class="h2" itemprop="name">Изменить адрес</h2>
        <hr class="gold_hr" style="margin-top: 15px; margin-bottom: 15px">
    </section>
</div>
<?= $this->render('_form', [
    'model' => $model,
]) ?>

