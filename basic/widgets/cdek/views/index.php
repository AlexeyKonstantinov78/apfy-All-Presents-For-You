<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJsFile('/js/plugins/cdekwidget/widjet.js', ['depends' => 'yii\web\YiiAsset', 'id' => 'ISDEKscript']);
$this->registerJsFile('/js/plugins/cdekwidget/js.js', ['depends' => 'yii\web\YiiAsset', 'id' => 'ISDEKscript']);
$this->registerCssFile('/js/plugins/cdekwidget/scripts/style.css');


?>
    <div class="row">
        <div class="col-xs-12">
            <div id="widjetCdek"></div>

        </div>
    </div>

    <?php $form = ActiveForm::begin([
        //'ajaxParam'=>'ajax',
        //'enableAjaxValidation'=>true,
        'options' => [
            'class' => 'row',
            'id' => 'formOrderCdek',
            'style' => 'margin-top:40px',
            'class' => '',
        ]

    ]); ?>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?= $form->field($order, 'name', [
                'options' => ['class' => 'form-group'],
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?= $form->field($order, 'phone', [
                'options' => ['class' => 'form-group'],
            ])->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '+7(999)-999-99-99',
            ]) ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?= $form->field($order, 'email', [
                'options' => ['class' => 'form-group'],
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12 hidden-md"></div>
        <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
            <?= $form->field($order, 'town', [
                'options' => ['class' => 'form-group'],
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
            <?= $form->field($order, 'street', [
                'options' => ['class' => 'form-group'],
            ])->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-xs-12 hidden-lg hidden-md hidden-xs"></div>

        <div class="col-lg-1 col-md-3 col-sm-4 col-xs-6">
            <?= $form->field($order, 'house', [
                'options' => ['class' => 'form-group'],
            ])->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-xs-12 hidden-lg hidden-sm"></div>

        <div class="col-lg-1 col-md-3 col-sm-2 col-xs-6">
            <?= $form->field($order, 'corps', [
                'options' => ['class' => 'form-group'],
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1 col-md-3 col-sm-2 col-xs-6">
            <?= $form->field($order, 'apartment', [
                'options' => ['class' => 'form-group'],
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1 col-md-3 col-sm-2 col-xs-6">
            <?= $form->field($order, 'entrance', [
                'options' => ['class' => 'form-group'],
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-1 col-md-3 col-sm-2 col-xs-6">
            <?= $form->field($order, 'floor', [
                'options' => ['class' => 'form-group'],
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12"></div>
        <div class="col-sm-6 col-xs-12">
            <?= $form->field($order, 'terms_of_use',
                [
                    'template' => "
                                        <label>\n{input} 
                                            <span class='terms_of_use'>Я прочитал и согласен с условиями 
                                                <a class='fancy_a transition_02' href='/page/polzovatelskoe-soglashenie' >пользовательского соглашения</a> 
                                                и <a class='fancy_a transition_02' href='/page/politika-konfidencialnosti'>политики конфиденциальности</a>.
                                                
                                            </span>
                                        </label>\n{hint}\n{error}
                                    "
                ]
            )->checkbox([
                'value'=>1,
                'uncheck'=>0,
                'checked '=>$order->terms_of_use?true:false,
                'label'=>false,
            ], false)?>
        </div>
        <div class="col-sm-6 col-xs-12">
            <div class="form-group">
                <?= Html::submitButton('Оформить', ['class' => 'btn btn-block black_white_form transition_02 black_el']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>