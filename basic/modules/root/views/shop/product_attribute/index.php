<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Атрибуты товаров';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-product-index">
    <p>
        <?= Html::a(
			'Создать атрибут для товара', 
			['create'], 
			[
				'class' => 'btn btn-success activity-view-link', 
				'title' => 'Создать атрибут для товара'
			]
		) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            //'value',
            //'id_product',
            //'user_id',

            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url,$model) {
					$link = Html::a(
						'<span class="glyphicon glyphicon-pencil"></span>', 
						$url,
						[
							//'value' => $url,
							'title' => 'Изменить название атрибута',
							'class' => 'activity-view-link',
						]
					);
				   return $link;
                },
				/*
                'delete' => function ($url,$model) {
                    return Html::a(
                    '<span class="glyphicon glyphicon-trash"></span>', 
                    $url);
                },
				//*/
            ],
        ],
        ],
    ]); ?>
</div>


<?php $this->registerJs(
    "$('.activity-view-link').click(function() {
		$('#modalHeader h4').text($(this).attr('title'));
		$.get(
			$(this).attr('href'),
			function (data) {
				$('.modal-body').html(data);
				$('#modalNew').modal();
			}  
		);
		return false;
	});
    "
); ?>
<?php
yii\bootstrap\Modal::begin([
	'header' => '<h4></h4>',
    'headerOptions' => ['id' => 'modalHeader', ],
    'id' => 'modalNew',
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
yii\bootstrap\Modal::end();
?>