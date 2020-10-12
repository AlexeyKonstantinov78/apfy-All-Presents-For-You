<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 08.07.2017
 * Time: 4:00
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
/*
$(document).on('beforeSubmit', '#login-form', function() {
    alert('Проверьте почты для подтверждения регистрации');
});
/*
$('#send_registration').on('submit', function(
    $.post(form.attr('action'), form.serialize, function(data){
        console.log(data);
    });
));
/**/
$this->registerCssFile('/css/site/pagesCss/cabinet.css');
$js = <<<JS
    const modalReg = $('#callbackReg'); 
    const buttonReg = `<p class="text-center"><button id="closeReg" class="return--pass red_but_font_filt transition_02">Авторизуйтесь!</button></p>`;
    $('#registration-form').on('beforeSubmit', function(event) {
        event.preventDefault(); 
        let formData = $(this).serialize();
        const fields = {
            email: $('.field-users-mail'),
            phone: $('.field-users-phone')
        };
        $.ajax({
            url: '/cabinet/registration',
            type: 'POST',
            data: formData,
            success: function(data){
                let mes = '';
                if(data.result){
                    $('#modalRegHeader').html(  '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>' +
                                                '<h3 class="text-center h3" style="font-size: 20px;margin-top: 10px;margin-bottom: 10px;">Уведомление по регистрации!</h3>'
                                                );
                    $('#modalReg').html(data.message + buttonReg);
                    modalReg.modal('show');
                    fields.email.removeClass('has-error');
                    fields.email.addClass('has-success');
                    fields.email.find('.help-block-error').html('');
                    fields.phone.removeClass('has-error');
                    fields.phone.addClass('has-success');
                    fields.phone.find('.help-block-error').html('');
                    
                } else {
                    if(data['users-mail']){
                        mes = '';
                        data['users-mail'].forEach(function(item, i, arr) {
                            console.log( i + ": " + item + " (массив:" + arr + ")" );
                            mes += `<p>` + item + `</p>`;
                        });
                        fields.email.removeClass('has-success');
                        fields.email.addClass('has-error');
                        fields.email.find('.help-block-error').html(mes);
                    }
                    if(data['users-phone']){
                        mes = '';
                        data['users-phone'].forEach(function(item, i, arr) {
                            console.log( i + ": " + item + " (массив:" + arr + ")" );
                            mes += `<p>` + item + `</p>`;
                        });
                        fields.phone.removeClass('has-success');
                        fields.phone.addClass('has-error');
                        fields.phone.find('.help-block-error').html(mes);
                    }
                }
            }
        });
        return false;
    });
    $('#callbackReg').on('click', '#closeReg', function(){
        modalReg.modal('hide');
    });
    modalReg.on('hidden.bs.modal', function (e) {
        setTimeout( 'location="/cabinet/auth";', 2000 );
    })
JS;
$this->registerJs($js);

?>
<main style="margin-bottom: 50px" id="registr" class="container">
    <section class="text-center">
        <hr class="gold_hr">
        <h1 class="h2 text-center h_gold text-uppercase">Регистрация</h1>
    </section>
    <div class="registr-wrapper">
        <section class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'registration-form',
                        'options' => ['class' => 'row form-default border-radius_none'],
                        //'enableAjaxValidation' => true,
                    ]); ?>
                        <div class="col-xs-12 col-md-6">
                            <?= $form->field($model, 'name', [
                                'inputOptions' => [
                                    'placeholder' => 'Введите имя...',
                                ],
                            ])->textInput([
                                'autofocus' => false,
                            ])-> label(false) ?>
                        </div>
                        <div class="col-xs-12 col-md-6 clear">
                            <?= $form->field($model, 'mail', [
                                'inputOptions' => [
                                    'placeholder' => 'Введите почту...',
                                ],
                            ])->textInput([
                                'autofocus' => false,
                            ])-> label(false) ?>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <?= $form->field($model, 'phone', [
                                'inputOptions' => [
                                    'placeholder' => 'Введите телефон...',
                                ],
                            ])
                                ->widget(\yii\widgets\MaskedInput::className(), [
                                    'mask' => '+7 (999) 999-99-99',
                                ])
                                ->textInput([
                                    'autofocus' => false,
                                ])
                                ->label(false) ?>
                        </div>
                        <div class="col-xs-12 col-md-6 clear">
                            <?= $form->field($model, 'password', [
                                'inputOptions' => [
                                    'placeholder' => 'Введите пароль...',
                                ],
                            ])->passwordInput([
                                'autofocus' => false,
                            ])-> label(false) ?>
                        </div>
                        <div class="col-xs-12 col-md-6 text-justify">
                            <?= $form->field($model, 'terms_of_use',
                                [
                                    'template' => "
                                        <label class='label-terms_of_use'>\n{input} 
                                            <span class='terms_of_use'>Я прочитал и согласен с условиями 
                                                <a target='_blank' class='fancy_a transition_02' href='/page/polzovatelskoe-soglashenie' >пользовательского соглашения</a> 
                                                и <a target='_blank' class='fancy_a transition_02' href='/page/politika-konfidencialnosti'>политики конфиденциальности</a>.
                                                
                                            </span>
                                        </label>\n{hint}\n{error}
                                    "
                                ]
                            )->checkbox([
                                'value'=>1,
                                'uncheck'=>0,
                                'checked '=>$model->terms_of_use?true:false,
                                'label'=>false,
                            ], false)?>
                        </div>
                        <div class="col-xs-12 col-md-6 text-center">
                            <?= Html::submitButton('Зарегистрироваться', ['class' => 'return--pass red_but_font_filt transition_02', 'name' => 'login-button']) ?>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </section>
    </div>
    <?php
    yii\bootstrap\Modal::begin([
        'headerOptions' => ['id' => 'modalRegHeader'],
        'id' => 'callbackReg',
        'size' => 'modal-sm',
        'clientOptions' => ['backdrop' => 'static']
    ]); ?>
    <div id='modalReg'  style="font-size: 14px;">

    </div>
    <?php
        yii\bootstrap\Modal::end();
    ?>
</main>