<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страница заказов';
$this->params['breadcrumbs'][] = $this->title;
//var_dump($status);
	//				exit();
?>
<div class="order-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            //'email:email',
            'phone',
            //'adress',
            // 'comment',
            'total',
            //'status',
			[
				'attribute' => 'status',
				'format' => 'text',
				'content'=>function($data){
					return $data->getNameStatus($data->status);
				},
			],
            'date_create',
            // 'date_edit',
            // 'user_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<?php
	$cnt=0;
	$sum = 0;
	foreach($model as $v){
		$sum += $v['total'];
		$cnt++;
	}
	echo 'количество заказов всего = ' . $cnt . '. На общую сумму = '.$sum.'. Средний чек = ' . $sum/$cnt;
?>
