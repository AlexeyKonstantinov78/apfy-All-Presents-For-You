<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = 'Изменить Статью: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="articles-update">

    <?= $this->render('_form', [
        'model' => $model,
		'model_seo' => $model_seo,
		'tree' => $tree,
    ]) ?>

</div>
