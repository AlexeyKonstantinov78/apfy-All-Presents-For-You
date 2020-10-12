<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 26.05.2017
 * Time: 4:12
 */
use yii\grid\GridView;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel, //TOLOOK
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        //'id',
        'name',
        //'description:ntext',
        'price',
        //'discount_price',

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}'
        ],
    ],
]); ?>
