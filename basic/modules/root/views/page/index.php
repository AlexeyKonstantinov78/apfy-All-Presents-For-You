<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="page-index">

    <p>
        <?= Html::a('Добавить страницу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		/*
		'rowOptions' => function ($model, $key, $index, $grid){
			var_dump($model);
			exit();
			return [
				'url' => 
			];
		},
		//*/
        'columns' => [
            //'id',
            'name',
            //'text:ntext',
			[
				'attribute' => 'is_main',
				'label'=>'Url',
				'content'=>function($data){
					if($data->is_main ==1) {
						$data->seo->slug = 'Главная';
					}
					return $data->seo->slug;
				}
			],
			//'text:ntext',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
</div>
