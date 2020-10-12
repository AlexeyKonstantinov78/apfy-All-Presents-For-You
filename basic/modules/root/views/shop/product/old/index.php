<?php
use app\modules\shop\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <p>
        <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="col-md-3">
        <select id="select_act" name="selected" class="form-control">
            <option>С отмеченными:</option>
            <option value="editcategory">Изменить категорию</option>
        </select>
    </div>

    <div style="clear: both"></div>
    <?php
    $category = new Category();
    $all = $category->generateTreeEditCat();
    $all = [-1 => 'Все'] + $all;
    $all = [-2 => 'Непривязанные'] + $all;


    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered check-product'
        ],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function($model, $key, $index, $widget) {
                    return ["value" => $model['id']];
                },
            ],
            //'id',
            [
                'format' => ['image',['width'=>'100','height'=>'100']],
                'attribute' => 'image',
                'label' => 'Изображение',
            ],
            [
                'attribute' => 'artid',
                'label' => 'Артикул',

            ],
            [
                'attribute' => 'name',
                'label' => 'Название',

            ],
            [
                'attribute' => 'categories',
                'label' => 'Категории',
                'filter' => Html::activeListBox($searchModel, 'id_category', $all, ['multiple' =>true])
            ],
            [
                'attribute' => 'price',
                'label' => 'Цена'
            ],
            [
                'attribute' => 'discount_price',
                'label' => 'Скидочная цена'
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator'=>function($action, $model, $key, $index){
                    return [$action,'id'=>$model['id']];
                },
            ],
        ],
    ]); ?>
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
</div>
<?php
yii\bootstrap\Modal::begin([
    'header' => '<h2>Групповой перенос товара.</h2>',
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'edit-cat',
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
?>
<form id='modalContent' action="/admin/shop/product/index" method="POST">
    <h3>Перенести в след категории</h3>
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
    <div id="hiddenProducts">

    </div>
    <div id="tree" name="ProductTCaregory[id]" style="height: 300px; overflow-y: scroll;">
    </div>
    <div class="form-control text-center" style="margin: 20px 0;border: none !important">
        <input class="btn btn-default" type="submit" name= 'submit-button' value="Изменить"  />
    </div>

</form>
<?php
yii\bootstrap\Modal::end();
?>
<!--
$('#select_act').on('change', function() {
	//alert( this.value );
	if(this.value == 'editcategory') $('#edit-cat').modal('show');
})
	<!-- $.each($(".check-product input:checked"), function(k,v) { console.log($(v).val()); }) -->
<?php
$script = "
$('#select_act').on('change', function() {
	//alert( this.value );
	if(this.value == 'editcategory') {
		$('#edit-cat').modal('show');
		$('#hiddenProducts').html('');
		$.each($('.check-product input:checked'), function(k,v){
			//console.log($(v).val()); 
			$('#hiddenProducts').append('<input type=\"hidden\" name=\"productsCheck[]\" value=\"'+$(v).val()+'\" />');
		})
	}
})
";
$this->registerJs($script, yii\web\View::POS_READY);
?>

