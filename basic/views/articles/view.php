<?php
use yii\widgets\Breadcrumbs;
use app\helpers\Image;

?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?=app\models\BreadcrumbsMicro::widget([
                    'homeLink' => [
                        'label' => 'Главная',
                        'url' => Yii::$app->homeUrl,
                    ],
                    //'itemTemplate' => '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">{link}</span><span class="itemSeparator">/</span></li>',
                    //'links' => isset(Yii::$app->params['breadcrumbs']) ? Yii::$app->params['breadcrumbs'] : [],
                    'links' => isset(Yii::$app->params['breadcrumbs']) ? Yii::$app->params['breadcrumbs'] : [],
                    'options' => [
                        'id' => 'breadcrumbs',
                        'style' => 'border-bottom: 1px solid #f3eccd;',
                    ],
                ]
            )?>
        </div>
    </div>
</div>
<main style="margin-bottom: 50px">
    <article>
        <section class="text-center">
            <hr class="gold_hr"/>
            <h1 class="h1 text-center h_gold"><?=$model->name?></h1>
        </section>
        <section class="container">
            <div class="row">
                <?php if(!empty($model->main_image->image)): ?>
                    <div class="col-xs-3">
                        <img src="<?=Image::thumb($model->main_image->image, null, 200)?>" alt="<?=$model->name?>" class="img_news pull-left" style="max-width: 100%; display: inline-block">
                    </div>
                    <div class="col-xs-9">
                <?php else: ?>
                    <div class="col-xs-12">
                <?php endif; ?>

                    <?=$model->text?>
                </div>
            </div>
        </section>
    </article>
</main>
