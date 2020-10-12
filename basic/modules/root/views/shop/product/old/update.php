<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Product */

$this->title = 'Изменить товар: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Изменить';

?>
<div class="product-update">

    <?= $this->render('_form', [
        'model' => $model,
		'model_images' => $model_images,
		'model_seo' => $model->seoTags,
		'attributes' => $attributes,
		'tree' => $tree,
    ]) ?>

</div>
