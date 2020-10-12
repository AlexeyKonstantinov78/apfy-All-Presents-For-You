<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form form-table-admin">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name', [
        'options' => ['class' => 'form-inline form-group tbl'],
    ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email', [
        'options' => ['class' => 'form-inline form-group tbl'],
    ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone', [
        'options' => ['class' => 'form-inline form-group tbl'],
    ])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'town', [
        'options' => ['class' => 'form-inline form-group tbl'],
    ])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'street', [
        'options' => ['class' => 'form-inline form-group tbl'],
    ])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'house', [
        'options' => ['class' => 'form-inline form-group tbl'],
    ])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'corps', [
        'options' => ['class' => 'form-inline form-group tbl'],
    ])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'apartment', [
        'options' => ['class' => 'form-inline form-group tbl'],
    ])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'floor', [
        'options' => ['class' => 'form-inline form-group tbl'],
    ])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'entrance', [
        'options' => ['class' => 'form-inline form-group tbl'],
    ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true], [
        'options' => ['class' => 'form-group tbl'],
    ]) ?>
    <?=$form->field($model, 'delivery')->dropDownList([
        '0' => 'Силами нашего интернет-магазина',
        '1' => 'Компанией СДЭК',
    ]); ?>
    <?=$form->field($model, 'delivery_choose')->dropDownList([
        '0' => 'Курьером',
        '1' => 'ПВЗ',
    ]); ?>
    <?=$form->field($model, 'payment_choose')->dropDownList([
        '0' => 'Наличными',
        '1' => 'Оплата картой',
        '2' => 'Онлайн оплата',
    ]); ?>
    <?php if($model->payment_choose == 2 && $model->getInvoice() !== null): ?>
        <?php
//        var_dump($model->getInvoice()->method);
//        exit;
        ?>
        <div class="row" style="border-bottom: 1px solid #bbbbbb;border-top: 1px solid #bbbbbb">
            <div class="col-xs-6">
                <?= $form->field($model->getInvoice(), 'method', [
                    'options' => ['class' => 'form-inline form-group tbl'],
                ])->textInput() ?>
            </div>
            <div class="col-xs-6">
                <?= $form->field($model->getInvoice(), 'status', [
                    'options' => ['class' => 'form-inline form-group tbl'],
                ])->dropDownList($model->getInvoice()->getAllNameStatus()); ?>
            </div>
            <div class="col-xs-6">
                <?= $form->field($model->getInvoice(), 'sum', [
                    'options' => ['class' => 'form-inline form-group tbl'],
                ])->textInput() ?>
            </div>
            <div class="col-xs-6">
                <?= $form->field($model->getInvoice(), 'message', [
                    'options' => ['class' => 'form-inline form-group tbl'],
                ])->textInput() ?>
            </div>
        </div>
    <?php endif; ?>
    <?= $form->field($model, 'delivery_price', [
        'options' => ['class' => 'form-inline form-group tbl'],
    ])->textInput() ?>
    <?= $form->field($model, 'total', [
        'options' => ['class' => 'form-inline form-group tbl'],
    ])->textInput() ?>

    <?= $form->field($model, 'status', [
        'options' => ['class' => 'form-inline form-group tbl'],
    ])->dropDownList($model->getAllNameStatus()); ?>

    <?= $form->field($model, 'date_create', [
        'options' => ['class' => 'form-inline form-group tbl'],
    ])->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
