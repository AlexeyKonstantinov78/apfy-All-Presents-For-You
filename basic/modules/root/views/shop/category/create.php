<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Category */

$this->title = 'Создать категорию';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">
    <?= $this->render('_form', [
        'model' => $model,
		'model_seo' => $model->seoTags,
        'rootUrl' => $rootUrl,
        'tree' => $tree,
        'treeFiltres' => $treeFiltres,
    ]) ?>
</div>
