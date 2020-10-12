<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
?>
<div class="row" id="searchCats" style="margin-bottom: 30px; margin-top: 20px">
    <?php $form = ActiveForm::begin(); ?>
        <div class="col-xs-12">
            <div class="form-inline" style="margin-bottom: 30px">
                <div class="form-group">
                    <label class="control-label" for="mainCatChoosing" style="margin-right: 40px">Выбранная категория для export товаров: </label>
                    <div class="input-group">
                        <?= $form->field($model, 'category_id')->dropDownList( ['prompt' => 'Выбирите категорию...']+$allCats, ['class' => 'form-control', 'id' => 'mainCatChoosing'])->label(false);?>
                        <!--<?=Html::dropDownList('mainCategory', 0 , ['prompt' => 'Выбирите категорию...']+$allCats, ['class' => 'form-control', 'id' => 'mainCatChoosing']);?>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 text-center">
            <div class="form-group">
                <?= Html::submitButton('Получить список товаров выбранной категории в excel', ['class' => 'btn btn-success' ]) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
    <div class="col-xs-6" style="margin-top: 30px">
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
        <ul id="searchCatsResults" style="height:400px; overflow-y: scroll;">
        </ul>
    </div>
</div>