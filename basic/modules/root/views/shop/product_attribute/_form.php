<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AttributeProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attribute-product-form">

    <?php $form = ActiveForm::begin([
		'id' => Yii::$app->request->isAjax ? 'model-form' : '',
        'enableClientValidation' => false,
        'enableAjaxValidation' => Yii::$app->request->isAjax ? true : false,
		]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'name' => 'submit-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
