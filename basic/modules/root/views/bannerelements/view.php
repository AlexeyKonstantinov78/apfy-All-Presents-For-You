<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BannerElements */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Элементы баннеров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-elements-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url:url',
            'img',
            'sort',
            'parent_id',
        ],
    ]) ?>

</div>
