<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Product */

$this->title = 'Добавить товар';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">
    <?= $this->render('_form', [
        'model' => $model,
		'model_images' => $model_images,
		'model_seo' => $model->seoTags,
		'attributes' => $attributes,
		'tree' => $tree,
        'allCats' => $allCats,
        'mainCats' => '',
    ]) ?>
</div>
