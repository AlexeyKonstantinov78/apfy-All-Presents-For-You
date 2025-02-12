<?php
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Product */
/* @var $form yii\widgets\ActiveForm */
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;
$jsProduct = <<<JS
$(document).ready(function(){
	$('#findCats').on('click', function(){
        $('#searchCatsResults').html('');
        $.post( '/root/shop/product/category_find', { query: $('#searchCatsInput').val() }, function( data ) {
            $('#searchCatsResults').html(data);
        })
    });
    $('#searchCatsResults').on('click', 'button', function(){
        $('#mainCatChoosing').val($(this).data('id'));
        $('#searchCatsResults').html('');
    })
})
JS;
$this->registerJs($jsProduct);
$active  = [
    '0' => 'Пока нет, а может удалить',
    '1' => 'Активен',
    //'list_2' => 'Товары таблицей с картинкой без фильтров', //одинаков с list_1
    '2' => 'Под заказ',
    //'list_4' => 'Тест',
    //'list_3' => 'Старая таблица',
];
//$form->field($model, 'active')->checkbox(['value' => '1', 'uncheck' => '0'])
?>

<div class="product-form">
	<ul class="nav nav-tabs">
	  <li class="active"><a href="#home" data-toggle="tab">Главная</a></li>
	  <li><a href="#category" data-toggle="tab">Категории</a></li>
	  <li><a href="#categoryMain" data-toggle="tab">Главная категории</a></li>
	  <li><a href="#attr" data-toggle="tab">Атрибуты</a></li>
	 <!-- <li><a href="#options" data-toggle="tab">Опции</a></li>-->
	  <li><a href="#gallery" data-toggle="tab">Изображения</a></li>
	</ul>
	<?php $form = ActiveForm::begin(); ?>
<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="home">
            <div class="form-group field-product-name required has-success" style="margin-bottom: 15px; margin-top: 15px">
                <label class="control-label" for="product-name">Последняя дата обновления - <?=$model->date?></label>
            </div>
			<?= $form->field($model, 'date')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>
			<?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'name_slug form-control'])->label('Название Товара') ?>
			<?= $form->field($model_seo, 'h1')->textInput(['maxlength' => true])?>
			<?= $form->field($model, 'scope')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
			<?= $form->field($model, 'weight')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
            <?= $form->field($model, 'active')->dropDownList($active); ?>
			<?= $form->field($model, 'artid')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
			<?= $form->field($model, 'gtin')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
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
								<?php if(isset($model->mainImage->image)) : ?>
									<?= HTML::img($model->mainImage->image) ?>
								<?php  else:  ?>
									<h4>Изображение не выбранно</h4>
								<?php endif; ?>
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
			<?= $form->field($model, 'description')->widget(CKEditor::className(),[
				'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
					'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
					'inline' => false, //по умолчанию false
				])
			]); ?>
			<?= $form->field($model, 'price')->textInput()->label('Цена')?>
			<?= $form->field($model, 'discount_price')->textInput()->label('Скидочная цена') ?>
			<?= $form->field($model, 'sort')->textInput()->label('Позиция') ?>
			<?= $form->field($model_seo, 'slug')->textInput(['maxlength' => true])?>
			<?= $form->field($model_seo, 'title')->textInput(['maxlength' => true])?>
			<?= $form->field($model_seo, 'description')->textInput(['maxlength' => true])?>
			<?= $form->field($model_seo, 'keywords')->textInput(['maxlength' => true])?>
		</div>
		<div class="tab-pane" id="category">
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
			<div id="tree" name="ProductTCaregory[id]" style="height:400px; overflow-y: scroll; margin-top: 30px">
			</div>

            
		</div>
		<div class="tab-pane" id="categoryMain">
            <div class="row" id="searchCats" style="margin-bottom: 30px; margin-top: 20px">
                <div class="col-xs-6">
                    <div class="form-inline" style="margin-bottom: 30px">
                        <div class="form-group">
                            <label class="control-label" for="mainCatChoosing" style="margin-right: 40px">Основная категория: </label>
                            <div class="input-group">
                                <?=Html::dropDownList('mainCategory', $mainCats , ['prompt' => 'Выбирите категорию...']+$allCats, ['class' => 'form-control', 'id' => 'mainCatChoosing']);?>
                            </div>
                        </div>
                    </div>
                    <div class="form-inline">
                        <div class="form-group">
                            <label class="control-label" for="searchCatsInput" style="margin-right: 10px" >Поиск основной категории товара (Нажимать только на кнопку найти!): </label>
                            <div class="input-group">
                                <input type="text" id="searchCatsInput" class="form-control" name="cats" placeholder="Поиск категории" maxlength="48" aria-required="true" >
                                <span class="input-group-btn"><button type="button" id="findCats" class="btn btn-default">Найти</button></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 ">
                    <h3 style="margin: 0">Результат поиска</h3>
                    <ul id="searchCatsResults" style="height:300px; overflow-y: scroll;">
                    </ul>
                </div>
            </div>
		</div>
		<div class="tab-pane" id="attr">
			<div id="choose_attr" class="form-group">
				<div class="form-inline">
					<label class="control-label">Доавление нового атрибута</label> 
					<?= Html::dropDownList('id_attributes', [1],
						ArrayHelper::map($attributes, 'id', 'name'),
						[
							'class' => 'form-control',
						]
						) ?>
					<label type="submit" id="add_attrebute" class="btn btn-default">Добавить атрибут</label>	
				</div>	
			</div>
			<?php foreach($model->productAttributesList as $k=>$v): ?>
				<?= $form->field($v, '[]value', [
					'options' => ['class' => 'form-inline form-group', 'data-mas'=>$k],
					'template' => "{label}\n{input}\n<label class='control-label btn btn-default del_attr' type='submit' data-del=".$v->id."><i class='fa fa-trash-o' aria-hidden='true'></i> Удалить?</label>\n{error}"
				])->textInput()->label($v->productAttribute->name) ?>

			<?php endforeach; ?>
			
		</div>
		<div class="tab-pane" id="options">
			
		</div>
		<div class="tab-pane" id="gallery">
			<div class="form-group field-images-image required">
				<div class="form-inline">
						<?= InputFile::widget([
						'language'   => 'ru',
						'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
						//'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории  
						'filter'     => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
						'name'       => 'add_images',
						'value'      => '',
						'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
						'options'       => ['class' => 'form-control'],
						'buttonOptions' => ['class' => 'btn btn-default'],
						'buttonName'	=> 'Выбрать изображение',
						'multiple'      => true       
					]);	?> <label id="add_images" type='submit' class="btn btn-default">Добавить изображения</label> 
				</div>
			</div>	
			<table  class="table table-striped table-bordered">
				<tbody id="put_images">
				<tr>
					<th class="th_image">
						Изображение
					</th>
					<th class="info_image">
						Поля
					</th>
				</tr>
				<?php 
					/*
					var_dump($model_images);
					//var_dump($k); 
					exit;
					//*/
					
					?>
				<?php if (is_array($model_images)) {?>
					<?php foreach ($model_images as $k=>$v): ?>
						<?php if($v->is_main == 1) Continue; ?>
						<?php 
						/*
						//var_dump($model_images);
						var_dump($v); 
						exit;
						//*/
						//$k++;
						?>
						<tr class="tr_images" data-numbimg='<?= $k ?>'>
							<th class="th_image">
								<?= HTML::img($v->image) ?>
							</th>
							<th class="info_image ">
								<div class="form-inline">
									<?= $form->field($v, '[' . $k . ']image')->widget(InputFile::className(), [
										'language'      => 'ru',
										'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
										'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров 
										'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
										'options'       => ['class' => 'form-control'],
										'buttonOptions' => ['class' => 'btn btn-default'],
										'multiple'      => false,       // возможность выбора нескольких файлов
										'buttonName'	=> 'Изменить изображение',
									])->label('Адрес изображения');?>
									
									<label type='submit' class="btn btn-default del_img" data-delImgId="<?= $v->id?>">Удалить изображение</label> 
								</div>
								<?= Html::input('hidden', 'Images[' . $k . '][delete]', '0', ['class' => 'delete_image']) ?>
								<?= Html::input('hidden', 'Images[' . $k . '][is_main]', '0') ?>
								<?= $form->field($v, '[' . $k . ']id')->HiddenInput(['class'=>'id_image'])->label(false)?>
								<div class="form-inline">
									<?= $form->field($v, '[' . $k . ']title')->textInput(['maxlength' => true])?>
									<?= $form->field($v, '[' . $k . ']alt')->textInput(['maxlength' => true])?>
								</div>
							</th>
						</tr>
					<?php endforeach; ?>
				<?php } ?>
				</tbody>
			</table>	
		</div>
	</div>
    
	

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
