<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AttributeProduct */

$this->title = 'Изменить атрибут товара: ';
$this->params['breadcrumbs'][] = ['label' => 'Атрибуты товаров', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="attribute-product-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
