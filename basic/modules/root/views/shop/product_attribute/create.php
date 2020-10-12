<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AttributeProduct */

$this->title = 'Создать атрибут товара';
$this->params['breadcrumbs'][] = ['label' => 'Атрибуты товаров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
