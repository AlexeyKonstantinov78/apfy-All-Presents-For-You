<?php
use yii\widgets\Breadcrumbs;
use app\helpers\Image;
use yii\widgets\LinkPager;

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
<main class="container" style="margin-bottom: 50px">
    <div class="row">
        <section class="text-center">
            <hr class="gold_hr"/>
            <h1 class="h1 text-center h_gold"><?=$model->name?></h1>
        </section>
        <?php foreach($articles as $k=>$v) { ?>
            <section class="col-xs-12">
                <h2 class="h2"><?=$v->name?></h2>
                <div class="description_news clear">
                    <?php if(!empty($v->main_image->image)){ ?>
                        <img src="<?=Image::thumb($v->main_image->image, null, 80)?>" alt="<?=$v->name?>" class="img_news pull-left">
                    <?php } ?>
                    <p class="text-center" style="font-size: 120%"><?=$v->description?></p>
                </div>
                <div class="link_news">
                    <a href="/articles/<?=$model->seoTags->slug?>/<?=$v->seoTags->slug?>" class="pull-right href_more none_outline default_button text-uppercase red_but_font_filt transition_02">Подробнее...</a>
                </div>
                <hr/>
            </section>
        <?php } ?>
    </div>
    <section class="row">
        <div class="col-xs-12 text-center">
            <div class="pagination-container pagination_dis">
                <?=yii\widgets\LinkPager::widget(array(
                    'pagination' => $pages,
                    'prevPageLabel'=>'<i class="fa fa-angle-left transition_02" aria-hidden="true"></i>',
                    'nextPageLabel'=>'<i class="fa fa-angle-right transition_02" aria-hidden="true"></i>',
                ));?>
            </div>
        </div>
    </section>
</main>