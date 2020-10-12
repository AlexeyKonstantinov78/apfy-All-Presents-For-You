<?php
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Articles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="articles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'name_slug form-control']) ?>
    <?php if(!empty($model->main_image->image)): ?>
        <?= $form->field($model->main_image, '[0]image')->widget(InputFile::className(), [
            'language'      => 'ru',
            'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
            'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров
            'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            'options'       => ['class' => 'form-control'],
            'buttonOptions' => ['class' => 'btn btn-default'],
            'multiple'      => false,       // возможность выбора нескольких файлов
            'buttonName'	=> 'Изменить картинку',
        ])->label('Адрес картинки');?>
    <?php else: ?>
        <?= $form->field($model->mainImage, '[0]image')->widget(InputFile::className(), [
            'language'      => 'ru',
            'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
            'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров
            'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            'options'       => ['class' => 'form-control'],
            'buttonOptions' => ['class' => 'btn btn-default'],
            'multiple'      => false,       // возможность выбора нескольких файлов
            'buttonName'	=> 'Изменить изображение',
            'model'			=> 'Images',
            //*
            'options'		=> [
                'id' 		=> 'change_main_image',
                'class' 	=> 'form-control',
            ],
            //*/
        ])->label('Адрес изображения');?>
    <?php endif; ?>

	
	<?= $form->field($model_seo, 'title')->textInput(['maxlength' => true])?>
	<?= $form->field($model_seo, 'description')->textInput(['maxlength' => true])?>
	<?= $form->field($model_seo, 'keywords')->textInput(['maxlength' => true])?>
	<?= $form->field($model_seo, 'slug')->textInput(['maxlength' => true])?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(CKEditor::className(),[
				'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
					'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
					'inline' => false, //по умолчанию false
					'allowedContent' => true,
				])
			]); ?>
	
	<div  id="category">
		   <?=  \wbraganca\fancytree\FancytreeWidget::widget([
			'options' =>[
				'id' => 'tree',
				'source' => $tree,
				'checkbox' => true,
				'selectMode' => 2,
				'select' => new JsExpression('function(event, data) { 
					$(this).fancytree(\'getTree\').generateFormElements();
				}'), 
			]
		]); ?>

		<div id="tree" name="ProductTCaregory[id]">
		</div>
		
	</div>
	<?= $form->field($model, 'active')->checkbox(['value' => '1', 'uncheck' => '0']) ?>

    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?= $form->field($model, 'date_public')->widget(DatePicker::classname(), [
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
