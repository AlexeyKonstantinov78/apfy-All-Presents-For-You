<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BannerElements */

$this->title = 'Создать элемент баннеров';
$this->params['breadcrumbs'][] = ['label' => 'Группы баннеров', 'url' => ['/root/bannergroups']];
$this->params['breadcrumbs'][] = ['label' => 'Элемент баннеров', 'url' => ['index', 'id'=>$model->parent_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-elements-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
