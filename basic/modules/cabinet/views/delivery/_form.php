<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-default border-radius_none'],
        //'enableAjaxValidation' => true,
    ]); ?>
    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'town', [
                //'options' => ['class' => 'form-inline form-group tbl'],
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'street', [
                //'options' => ['class' => 'form-inline form-group tbl'],
            ])->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'house', [
                //'options' => ['class' => 'form-inline form-group tbl'],
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'corps', [
                //'options' => ['class' => 'form-inline form-group tbl'],
            ])->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'apartment', [
                //'options' => ['class' => 'form-inline form-group tbl'],
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'floor', [
                //'options' => ['class' => 'form-inline form-group tbl'],
            ])->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'entrance', [
                //'options' => ['class' => 'form-inline form-group tbl'],
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'return--pass red_but_font_filt transition_02' : 'return--pass red_but_font_filt transition_02']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
