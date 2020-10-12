<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'cabinet';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create cabinet', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'mail',
            'password',
            'name',
            'lastname',
            // 'surname',
            // 'adress',
            // 'status',
            // 'data_create',
            // 'date_last_visit',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
