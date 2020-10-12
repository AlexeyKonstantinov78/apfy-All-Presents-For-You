<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 15.08.2017
 * Time: 2:43
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->registerCssFile('/css/site/pagesCss/cabinet.css');
$js = <<<JS
    $('#registration-form').on('beforeSubmit', function(event){
        event.preventDefault();
        console.log($('#registration-form #dynamicmodel-mail').val());
        /*  */
        $.ajax({
            url: '/cabinet/registration/reset',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                if(data.result === true){
                    $('#modalCabinetHeader')
                    .html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 class="text-center h3" style="font-size: 20px;margin-top: 10px;margin-bottom: 10px;">Пароль Сброшен!</h3>');
                    $('#modalCabinetBody')
                    .html('<p>Письмо успешно отправлено с новым паролем, можно посмотреть почту!</p><p class="text-center"><button class="closeCabinet closeCabinetNavRepeatSend return--pass red_but_font_filt transition_02">Закрыть!</button></p>');
                    $('#callbackCabinet').modal('show');
                    $('.field-dynamicmodel-mail').addClass('has-success');
                    $('.field-dynamicmodel-mail').removeClass('has-error');
                    $('.field-dynamicmodel-mail').find('.help-block-error').html('');
                } else {
                    $('.field-dynamicmodel-mail').removeClass('has-success');
                    $('.field-dynamicmodel-mail').addClass('has-error');
                    $('.field-dynamicmodel-mail').find('.help-block-error').html(data.message);
                }
            },
        });
        return false;
    });
    $('#callbackCabinet').on('click', '.closeCabinetNavRepeatSend', function(){
        $('#callbackCabinet').modal('hide');
        setTimeout( 'location="/cabinet/auth";', 500 );
    });
JS;
$this->registerJs($js);
?>
<main style="margin-bottom: 50px" id="registr" class="container">
    <section class="text-center">
        <hr class="gold_hr">
        <h1 class="h2 text-center h_gold text-uppercase">Востановить пароль!</h1>
    </section>
    <div class="registr-wrapper">
        <section class="container-fluid">
            <?php
            $form = ActiveForm::begin([
                'id' => 'registration-form',
                'options' => ['class' => 'row form-default border-radius_none'],
                'enableAjaxValidation' => false,
            ]); ?>
                <div class="col-xs-12 col-md-12">
                    <?= $form->field($model, 'mail', [
                        'inputOptions' => [
                            'placeholder' => 'Введите почту...',
                            'type' => 'mail',
                            'class' => 'form-control required'
                        ],
                    ])->textInput([
                        'autofocus' => false,
                    ])-> label(false) ?>
                </div>
                <div class="col-xs-12 col-md-12 text-center">
                    <?= Html::submitButton('Восстановить пароль', ['class' => 'return--pass red_but_font_filt transition_02', 'type' => 'button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </section>
    </div>
</main>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalCabinetHeader'],
    'id' => 'callbackCabinet',
    'size' => 'modal-sm',
    'clientOptions' => ['backdrop' => 'static']
]); ?>
    <div id='modalCabinetBody'  style="font-size: 14px;">

    </div>
<?php
yii\bootstrap\Modal::end();
?>