<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BannerGroups */

$this->title = 'Создать группу';
$this->params['breadcrumbs'][] = ['label' => 'Группа баннеров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-groups-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
