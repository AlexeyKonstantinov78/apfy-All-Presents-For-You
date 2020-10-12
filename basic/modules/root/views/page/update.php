<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Page */

$this->title = 'Изменить страницу: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="page-update">


    <?= $this->render('_form', [
        'model' => $model,
		'model_seo' => $model->seoTags,
    ]) ?>

</div>
