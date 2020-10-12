<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJs("var url_sort = '/admin/bannerelements/sortorder'"); 
$this->title = 'Элемент группы баннера ';
$this->params['breadcrumbs'][] = ['label' => 'Группы баннеров', 'url' => ['/root/bannergroups']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-elements-index">
    <p>
        <?= Html::a('Создать элемент группы баннера', ['create' . '?id=' . $id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'rowOptions' => ['class'=>'elements_group'],
        'columns' => [
            //'id',
            'name',
            'url:url',
            'img',
            //'sort',
			[
				'attribute' => 'sort',
				'label' => 'Сортировка',
				'format' => 'html',
				'contentOptions' =>['class' => 'text-center'],
				'content'=>function($data){
					return '<span data-move="up" title="Вверх" class=\'glyphicon arrow_elements glyphicon-arrow-up up_elements\'></span><span data-move="down" title="Вниз"  class=\'glyphicon arrow_elements glyphicon-arrow-down down_elements\'></span>';
				},
			],
            // 'parent_id',
            // 'user_id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
