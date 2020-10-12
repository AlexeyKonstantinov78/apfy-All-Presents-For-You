<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'import')->fileInput()->label("Файл выгрузки из других систем") ?>

    <button>Импортировать</button>

	<?php if(!empty($model->import)):?>
	<div style="clear: both"></div>
		<b>Импорт успешно произведен</b>
	
		<div style="color: darkgreen">Добавлено товаров: <b><?=count($result[0])?></b></div>
		<div style="max-height: 200px; overflow: auto">
			<?php if(!empty($result[0])) foreach($result[0] as $new) { ?>
				<input type="checkbox" /> <b><?=$new['id_int']?><b> [<a target="_blank" href="/root/shop/product/update?id=<?=$new['id']?>">изм.</a>] <br/>
			<?php }?>
		</div>
		<div style="color: black">Изменено товаров: <b><?=count($result[1])?></b></div>
		<div style="max-height: 200px; overflow: auto">
			<?php if(!empty($result[1])) foreach($result[1] as $edit) { ?>
				<input type="checkbox" /> <b><?=$edit['id_int']?></b> [<a target="_blank" href="/root/shop/product/update?id=<?=$edit['id']?>">изм.</a>] <br/>
			<?php }?>
		</div>
	
	<?php endif;?>
	
<?php ActiveForm::end() ?>