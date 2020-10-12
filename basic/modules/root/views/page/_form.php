<?php
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\ElFinder;

?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>
	
    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'name_slug form-control']) ?>
	<?= $form->field($model, 'is_main')
          ->checkBox(['label' => 'Отображать на главной? ', 'uncheck' => '0', 'selected' => '1']); ?>
	<?= $form->field($model_seo, 'title')->textInput(['maxlength' => true])?>
	<?= $form->field($model_seo, 'description')->textInput(['maxlength' => true])?>
	<?= $form->field($model_seo, 'keywords')->textInput(['maxlength' => true])?>
	<?= $form->field($model_seo, 'slug')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'template')->dropDownList([
            '' => 'По умолчанию',
            'contact' => 'Шаблон для контактов',
            'about' => 'Шаблон для страницы о нас',
            'delivery' => 'Шаблон для доставка',
            'pvz' => 'Шаблон для ПВЗ',
    ]) ?>
	<?= $form->field($model, 'text')->widget(CKEditor::className(),[
		'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
			'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
			'inline' => false, //по умолчанию false
		])
	]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
