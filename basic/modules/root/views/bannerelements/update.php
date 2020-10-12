<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BannerElements */

$this->title = 'Изменить элемент баннер: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Группы баннеров', 'url' => ['/root/bannergroups']];
$this->params['breadcrumbs'][] = ['label' => 'Элементы баннеров', 'url' => ['index', 'id'=>$model->parent_id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="banner-elements-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
