<?php

//use yii\helpers\ArrayHelper;
//use mihaildev\elfinder\ElFinder;
/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Category */
/* @var $form yii\widgets\ActiveForm */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;
//var_dump($treeFiltres);
//exit;
//var_dump($model->mainImage);
//exit();
?>

<div class="category-form">

    <?php $form = ActiveForm::begin([
		'id' => Yii::$app->request->isAjax ? 'model-form' : '',
        'enableClientValidation' => false,
        'enableAjaxValidation' => Yii::$app->request->isAjax ? true : false,
		]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'name_slug form-control'])->label('Название') ?>

    <?= $form->field($model, 'parent_id')->dropDownList($tree,['prompt' => 'Выбирите категорию...']); ?>
    <?= $form->field($model, 'is_brand')->checkbox() ?>
    <?= Html::input('hidden', 'BaseSeoUrl', $model->seoTags->slug, ['id'=>'BaseSeoUrl']) ?>
    <?php if($model->seoTags->slug != '') { ?>
        <div class="form-group has-error">
            <div class="help-block">При вводе текста ссылка не измениться, необходимо менять вручную.
                <br/> Сейчас она выглядит так: <strong><?=$model->seoTags->slug?></strong></div>
        </div>
    <?php } ?>

    <?= $form->field($model->seoTags, 'h1')->textInput(['maxlength' => true])?>
    <?= $form->field($model->seoTags, 'title')->textInput(['maxlength' => true])?>


	<?= $form->field($model->seoTags, 'description')->textInput(['maxlength' => true])?>

	<?= $form->field($model->seoTags, 'keywords')->textInput(['maxlength' => true])?>

	<?= $form->field($model->seoTags, 'slug')->textInput(['maxlength' => true])?>

    <?= Html::input('hidden', 'hiddenRootUrl', $rootUrl, ['id'=>'hiddenRootUrl']) ?>

    <?php if($rootUrl != '') { ?>
        <div class="form-group has-error">
            <?= Html::input('hidden', 'hiddenRootUrl', $rootUrl, ['id'=>'hiddenRootUrl']) ?>
            <div class="help-block">Ссылки родительских категорий: <strong><?=$rootUrl?></strong></div>
        </div>
    <?php } ?>
    <table  class="table table-striped table-bordered">
        <tbody>
        <tr>
            <th class="th_image" style="min-width: 200px">
                Основное изображение
            </th>
            <th class="info_image">
                Поля
            </th>
        </tr>
        <tr class="tr_images">
            <th class="th_image">
                <div id="main_image" class="text-center">
                    <?php if(isset($model->mainImage->image)) { ?>
                        <?= HTML::img($model->mainImage->image) ?>
                    <?php } else { ?>
                        <h4>Изображение не выбранно</h4>
                    <?php } ?>
                </div>
            </th>
            <th class="info_image ">
                <div class="form-inline">
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
                </div>
                <?= Html::input('hidden', 'Images[0][delete]', '0', ['class' => 'delete_image']) ?>
                <?= $form->field($model->mainImage, '[0]is_main')->HiddenInput(['class'=>'id_image'])->label(false)?>
                <?= $form->field($model->mainImage, '[0]id')->HiddenInput(['class'=>'id_image'])->label(false)?>
                <div class="form-inline">
                    <?= $form->field($model->mainImage, '[0]title')->textInput(['maxlength' => true])?>
                    <?= $form->field($model->mainImage, '[0]alt')->textInput(['maxlength' => true])?>
                </div>
            </th>
        </tr>
        </tbody>
    </table>
    <div class="form-group field-filtres">
        <label class="control-label">Дополнительные фильтры отображаемые в категории</label>
        <div id="filtres" style="height:300px; overflow-y: scroll">
            <?php //var_dump($treeFiltres); ?>
            <?=  \wbraganca\fancytree\FancytreeWidget::widget([
                'options' =>[
                    'id' => 'filtres',
                    'source' => $treeFiltres,
                    'checkbox' => true,
                    'selectMode' => 2,
                    'select' => new JsExpression('function(event, data) { 
                            $(this).fancytree(\'getTree\').generateFormElements();
                        }'),
                ]
            ]); ?>
        </div>
    </div>

	<?= $form->field($model, 'active')->checkbox(['value' => '1', 'uncheck' => '0']) ?>
    <?= $form->field($model, 'small')->textInput(['maxlength' => true])?>
    <?= $form->field($model, 'description')->widget(CKEditor::className(),[
		'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
			'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
			'inline' => false, //по умолчанию false
		])
	]); ?>
    <?= $form->field($model, 'tpl')->textInput(['maxlength' => true])?>
    <?php /* $form->field($model, 'parent_id')->hiddenInput(['value' => $model->parent_id ? $model->parent_id : null])->label(''); */ ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'name' => 'submit-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
