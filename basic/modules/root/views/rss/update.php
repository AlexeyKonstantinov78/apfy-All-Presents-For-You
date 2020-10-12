<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\root\models\Rss */

$this->title = 'Update Rss: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Rsses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rss-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
