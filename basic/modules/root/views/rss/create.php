<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\root\models\Rss */

$this->title = 'Create Rss';
$this->params['breadcrumbs'][] = ['label' => 'Rsses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rss-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
