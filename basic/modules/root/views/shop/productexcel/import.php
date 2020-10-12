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
            <?php if(!empty($result)): ?>
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-2">Внутренний индификатор</div>
                        <div class="col-xs-3">Артикул</div>
                        <div class="col-xs-7">Название</div>
                    </div>
                    <?php foreach ($result as $v): ?>
                        <div class="row">
                            <div class="col-xs-2"><?=$v['id']?></div>
                            <div class="col-xs-3"><?=$v['artid']?></div>
                            <div class="col-xs-7"><?=$v['name']?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

