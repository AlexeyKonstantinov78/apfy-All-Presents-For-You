<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории статей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-category-index">

    <p>
        <?= Html::a('Создать категорию статей', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=  \wbraganca\fancytree\FancytreeWidget::widget([
    'options' =>[
		'id' => 'tree',
        'source' => $tree,
        'extensions' => ['table','wide'],
        'table' => [
			'checkboxColumnIdx' => null, // render the checkboxes into the this column index (default: nodeColumnIdx)
			'indentation' => 16,         // indent every node level by 16px
			'nodeColumnIdx' => 0,         // render node expander, icon, and title to this column (default: #0)
		],
		'wide' => [],
		'renderColumns' => new JsExpression('function(event, data) {
        var node = data.node,
          $tdList = $(node.tr).find(">td");
         
            
        $tdList.eq(1).html("<a title=\"Добавить подкатегорию\" onclick=\'addnodeart(\""+node.key+"\")\'><span class=\'glyphicon glyphicon-plus\'></span></a> <a title=\"Изменить категорию\" value=\'/root/articlecategory/update?id="+node.key+"\' class=\'showModalButton\'><span class=\'glyphicon glyphicon-pencil\'></span></a> <a title=\"Удалить категорию\" onclick=\'yii.confirm(\"Вы точно хотите удалить категорию "+node.title+"\",deletenodeart)\'><span class=\'glyphicon glyphicon-trash\'></span></a> <a title=\"Вверх\" onclick=\'movenode(\""+node.key+"\",\"up\")\'><span class=\'glyphicon glyphicon-arrow-up\'></span></a> <a title=\"Вниз\" onclick=\'movenode(\""+node.key+"\",\"down\")\'><span class=\'glyphicon glyphicon-arrow-down\'></span></a>");
      }'),
    ]
]); ?>
<table id="tree" class="table table-condensed table-hover table-striped fancytree-fade-expander">
    <colgroup>
    <col></col>
    <col></col>
    </colgroup>
    <thead>
        <tr> <th> </th>  <th>Действия</th> </tr>
    </thead>
	<tbody></tbody>
</table>
</div>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
yii\bootstrap\Modal::end();
?>