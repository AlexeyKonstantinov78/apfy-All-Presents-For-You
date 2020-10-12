<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BannerGroups */

$this->title = 'Изменить группу баннеров: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Группа баннеров', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="banner-groups-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
