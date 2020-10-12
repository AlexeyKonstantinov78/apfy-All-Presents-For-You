<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'История заказов';
$this->params['breadcrumbs'][] = $this->title;
$js = <<<JS
    let deliveryDefaultVal = $('#deliveryDefault option:selected').val();
    if(deliveryDefaultVal != '0'){
        $('#history-table')
            .find('.history-column[data-key='+deliveryDefaultVal+'] .history-column_address')
            .append('<i class="fa fa-check-circle-o pull-right" style="color:#3c763d; font-size: 24px;" aria-hidden="true"></i>');
    }
    $('#deliveryDefaultChange').on('click', function() {
        
        $.ajax({
            url: '/cabinet/delivery/change',
            type: 'GET',
            data: {
                delivery_id: $('#deliveryDefault option:selected').val()
            },
            success: function(data){
                deliveryDefaultVal = $('#deliveryDefault option:selected').val();
                $('#history-table').find('i.fa-check-circle-o').remove();
                $('#history-table').find('.history-column[data-key='+deliveryDefaultVal+'] .history-column_address')
                    .append('<i class="fa fa-check-circle-o pull-right" style="color:#3c763d; font-size: 24px;" aria-hidden="true"></i>');
            }
        });
    });
    $('.delivery_delete').on('click', function(){
        if(confirm('Точно хотите удалить адрес доставки')){
            $.post('/cabinet/delivery/delete', {id: $(this).data('id')},  function( data ) { //  загружаем данные с сервера с помощью HTTP запроса методом GET
                console.log(data) // вставляем в элемент <div> данные, полученные от сервера
                location="/cabinet/delivery";
            })
        }
        return false;
    })
JS;
$this->registerJs($js);

//var_dump($modelsDelivery); exit;
?>
<div class="row">
    <div class="col-xs-12">
        <ul id="breadcrumbs" style="
            border-bottom: 1px solid #f3eccd;
        " itemscope="" itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="/" itemprop="item">
                    <span itemprop="name">Главная</span>
                </a>
                <meta itemprop="position" content="1">
                <span class="itemSeparator">/</span>
            </li>
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="/cabinet/" itemprop="item">
                    <span itemprop="name">Профиль</span>
                </a>
                <meta itemprop="position" content="2">
                <span class="itemSeparator">/</span>
            </li>
            <li class="active">
                <span>
                    <span itemprop="name">Адреса доставки</span>
                </span>
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <section class="col-xs-12 text-center">
        <h2 class="h2" itemprop="name">Адреса доставки</h2>
        <hr class="gold_hr" style="margin-top: 15px; margin-bottom: 15px">
    </section>
</div>
<div class="row">
    <div class="col-xs-12" style="margin-bottom: 15px">
        <div class="row">
            <div class="col-xs-7">
                <div class="row">
                    <div class="col-xs-12">
                        <label for="">Изменить адрес доставки по умолчанию:</label>
                    </div>
                    <div class="col-xs-7">
                        <?php if($modelsDelivery>0): ?>
                            <select class="form-control" id="deliveryDefault">
                                <option
                                    <?=\Yii::$app->user->identity->delivery_default === 0 ? 'selected' : ''; ?>
                                    value="0"
                                >Нет</option>
                                <?php foreach($modelsDelivery as $k): ?>
                                    <option
                                        <?=\Yii::$app->user->identity->delivery_default === $k->id ? 'selected' : ''; ?>
                                        value="<?=$k->id?>"
                                    >
                                        Доставка в г. <?=$k->town?>, улица <?=$k->street?> ...
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <span>
                                Нет доставок для выбора
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-5">
                        <button id="deliveryDefaultChange" type="button" class="return--pass red_but_font_filt transition_02">
                            Изменить Адрес
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-xs-5">
                <div class="row">
                    <div class="col-xs-12">
                        <label for="">Добавить адрес доставки:</label>
                    </div>
                    <div class="col-xs-12">
                        <a href="/cabinet/delivery/create" class="return--pass red_but_font_filt transition_02">
                            Добавить адрес доставки
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12" >
        <?php
        echo yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            //'tableOptions' => ['id' => 'history-table', 'class' => 'table table-striped table-bordered'],
            'tableOptions' => ['id' => 'history-table', 'class' => 'table table-striped'],
            'headerRowOptions' => ['class'=>'history-column_header',],
            'rowOptions' => ['class' => 'history-column transition_02'],
            'columns' => [
                /**/
                [
                    'attribute' => 'address',
                    'label' => 'Адрес',
                    'format' => 'raw',
                    'value' => function ($model, $key, $index, $column) {
                        $content = 'г. ' . $model['town'];
                        $content .= ', улица ' . $model['street'];
                        $content .= ', д.' . $model['house'];
                        $content .= ', кв.' . $model['apartment'];
                        //$active = $model->{$column->attribute} === 1;
                        //var_dump($model);
                        //exit;
                        return \yii\helpers\Html::tag(
                            'span',
                            $content,
                            [
                                'class' => '',
                            ]
                        );
                    },

                    'contentOptions' => ['class' => 'history-column_address'],
                ],
                /* * /
                [
                    'attribute' => 'deliveryall',
                    'label' => 'Доставка',
                    'format' => 'raw',
                    'value' => function ($model, $key, $index, $column) {
                        $content = $model->getNameDelivery($model['delivery_choose']);
                        $content .= ', ' . $model->getNameDeliveryChoose($model['delivery_choose']);
                        return \yii\helpers\Html::tag(
                            'span',
                            $content,
                            [
                                'class' => '',
                            ]
                        );
                    },
                ],
                /**/
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'',
                    'headerOptions' => [],
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url,$model) {
                            return Html::a(
                                'Изменить',
                                $url,
                                [
                                    'class' => 'transition_02 black_purpule_a',
                                    'style' => 'display:inline-block; margin:10px'
                                ]
                            );
                        },
                        'delete' => function ($url,$model) {
                            return Html::a(
                                'Удалить',
                                $url,
                                [
                                    'class' => 'transition_02 black_purpule_a delivery_delete',
                                    'style' => 'display:inline-block; margin:10px',
                                    'data-id' => $model->id
                                ]
                            );
                        },
                    ],
                    'contentOptions' => ['class' => 'text-right history-column_action'],
                    'headerOptions' => ['class'=>'text-right',],
                ],
            ],
        ]);
        ?>
        <div class="pagination-container pagination_dis text-center">
            <?=yii\widgets\LinkPager::widget(array(
                'pagination' => $dataProvider->pagination,
                'prevPageLabel'=>'<i class="fa fa-angle-left transition_02" aria-hidden="true"></i>',
                'nextPageLabel'=>'<i class="fa fa-angle-right transition_02" aria-hidden="true"></i>',
            ));?>
        </div>
    </div>
</div>