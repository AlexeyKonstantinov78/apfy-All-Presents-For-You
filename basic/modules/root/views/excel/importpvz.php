<?php
use yii\widgets\ActiveForm;
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
            <?= $form->field($model, 'import')->fileInput()->label("Файл выгрузки из других xls") ?>
            <button>Импортировать</button>
            <?php ActiveForm::end() ?>
            <?php //var_dump($result); exit; ?>

        </div>
    </div>
</div>

