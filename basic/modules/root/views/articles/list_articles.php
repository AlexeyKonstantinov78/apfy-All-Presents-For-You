<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 26.05.2017
 * Time: 4:12
 */
use yii\grid\GridView;
?>
<?php $tmp =  ' {update} {delete}'; ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [

        'id',
        'name',
        //'description',
        //'text:ntext',
        'date',
        'date_public',
        // 'user_id',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}'
        ],
        //['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
