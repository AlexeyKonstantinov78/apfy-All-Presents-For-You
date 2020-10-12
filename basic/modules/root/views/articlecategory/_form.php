<?php
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model app\models\ArticleCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-category-form">

    <?php $form = ActiveForm::begin([
		'id' => Yii::$app->request->isAjax ? 'model-form' : '',
        'enableClientValidation' => false,
        'enableAjaxValidation' => Yii::$app->request->isAjax ? true : false,
		]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'name_slug form-control'])->label('Название') ?>
	<?= $form->field($model->seoTags, 'title')->textInput(['maxlength' => true])?>
	<?= $form->field($model->seoTags, 'description')->textInput(['maxlength' => true])?>
	<?= $form->field($model->seoTags, 'keywords')->textInput(['maxlength' => true])?>
	<?= $form->field($model->seoTags, 'slug')->textInput(['maxlength' => true])?>
	<?= $form->field($model->mainImage, '[0]image')->widget(InputFile::className(), [
										'language'      => 'ru',
										'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
										'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров 
										'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
										'options'       => ['class' => 'form-control'],
										'buttonOptions' => ['class' => 'btn btn-default'],
										'multiple'      => false,       // возможность выбора нескольких файлов
										'buttonName'	=> 'Изменить картинку',
									])->label('Адрес картинки');?>



    <?= $form->field($model, 'description')->widget(CKEditor::className(),[
		'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
			'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
			'inline' => false, //по умолчанию false
		])
	]); ?>


    <?= $form->field($model, 'active')->checkbox(['value' => '1', 'uncheck' => '0']) ?>
	<?= $form->field($model, 'parent_id')->hiddenInput(['value' => $model->parent_id ? $model->parent_id : null])->label(''); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'name' => 'submit-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
