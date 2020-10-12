<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\users\models\WishList */

$this->title = 'Create Wish List';
$this->params['breadcrumbs'][] = ['label' => 'Wish Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wish-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
