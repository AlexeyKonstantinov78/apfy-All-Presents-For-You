<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Группа баннеров';
$this->params['breadcrumbs'][] = $this->title;
$tmp =  '{bannerelements/index}';
?>
<div class="banner-groups-index">
	
	<p>
		<?= Html::a('Создать группу баннеров', ['create'], ['class' => 'btn btn-success']) ?>
		
	</p>
	<?php $tmp .=  ' {update} {delete}'; ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //'id',
            'name',
            'slug',

            [
				'class' => 'yii\grid\ActionColumn',
				'template' => $tmp,
				'buttons' => [
					'update' => function ($url,$model) {
						return Html::a(
						'<span class="glyphicon glyphicon-cog"></span>', 
						$url);
					},
					'bannerelements/index' => function ($url,$model,$key) {
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
					},
				],
			],
        ],
    ]); ?>
</div>
