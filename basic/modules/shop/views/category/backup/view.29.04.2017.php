<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Category */
/*testing
var_dump($model->isLeaf());
exit;
// end testing */
$item = 3; // 1 - нет товаров, другие значения есть товары
//главная картинка для parallax
if(empty($model->img)) $main_image = '/img/tmp/hero19.jpg';
else $main_image = $model->img;

?>
<header class="height-100 imagebg cover cover-1 parallax transition--fade" data-parallax="scroll" data-image-src="<?=$main_image?>">
    <!--нужна заглушка, если не будет фотки категории-->
    <div class="container pos-vertical-center">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h1><?=$model->name?></h1>
                <div class="lead" style="font-size: 20px"><?=$model->description?></div>
            </div>
        </div>
    </div>
    <?=Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Главная',
            'url' => Yii::$app->homeUrl,
        ],
        'links' => isset(Yii::$app->params['breadcrumbs']) ? Yii::$app->params['breadcrumbs'] : [],
        'options' => [ 'id' => 'breadcrumbs', 'class' => 'text-center'],
    ])?>
</header>
<!-- to look paralax -->
<?php //отображение подкатегорий ?>

<?php if($item === 1) { ?>
    <?php //если есть товары начало ?>
    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-3 col-sm-6 col-xs-12">
                <div class="sidebar">
                    <div class="sidebar__widget">
                        <h6>Search Site</h6>
                        <hr>
                        <form method="post">
                            <div class="input-with-icon">
                                <i class="icon-Magnifi-Glass2"></i>
                                <input type="search" placeholder="Type Here">
                            </div>
                        </form>
                    </div>
                    <!--end widget-->
                    <?php if($model->isLeaf() === false) { ?>
                        <div class="sidebar__widget">
                            <h6>Подкатегории</h6>
                            <hr>
                            <ul class="link-list">
                                <?php foreach($model->children as $ch) {?>
                                    <li>
                                        <a href="<?='/category/'.($ch->seoTags->slug == null ? $ch->id : $ch->seoTags->slug)?>">
                                            <?=$ch->name?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                    <!--end widget-->
                    <div class="sidebar__widget">
                        <h6>Фильтры</h6>
                        <hr>
                        <ul class="tag-cloud">
                            <li>
                                <a href="#" class="btn btn--sm btn--square">
                                <span class="btn__text">
                                    цвет
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn--sm btn--square">
                                <span class="btn__text">
                                    Цвет белый
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn--sm btn--square">
                                <span class="btn__text">
                                    Цвет серый
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn--sm btn--square">
                                <span class="btn__text">
                                    Цена по возрастанию
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn--sm btn--square">
                                <span class="btn__text">
                                   Цена по убыванию
                                </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--end widget-->
                    <div class="sidebar__widget">
                        <h6>About Us</h6>
                        <hr>
                        <p>
                            We're a digital focussed collective working with individuals and businesses to establish rich, engaging online presences.
                        </p>
                    </div>
                    <!--end widget-->
                </div>
            </aside>
            <main class="col-md-9 col-sm-6 col-xs-12">
                <div class="row">
                    <div class="sidebar__widget">
                        <h6>Товары</h6>
                        <hr>
                    </div>
                    <?php foreach($model->children as $ch) {?>
                        <a href="#" class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card card-7">
                                <div class="card__image">
                                    <img alt="Pic" src="/img/tmp/product-large-1.jpg">
                                </div>
                                <div class="card__body boxed bg--white">
                                    <div class="card__title">
                                        <h5><?=$ch->name?></h5>
                                    </div>
                                    <div class="card__price">
                                        <span class="type--strikethrough rub_after">129</span>
                                        <span class="rub_after">89</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php } ?>
                </div>
            </main>
        </div>
    </div>
    <?php //если есть товары конец ?>
<?php } elseif($item === 2) { ?>
    <section id="sub_categories" class="container masonry masonry-shop" style="max-width: 4400px">
        <h3 class="text-center row">Подкатегории</h3>
        <div class="row">
            <?php foreach($model->children as $ch) {?>
                <a class="col-md-3 col-sm-4 col-xs-6 sub_cat" href="<?='/category/'.($ch->seoTags->slug == null ? $ch->id : $ch->seoTags->slug)?>">
                    <div class="shop-item shop-item-1 row">
                        <!--div class="shop-item__price hover--reveal">
                            <span class="type--strikethrough">329.00</span>
                            <span>299.00</span>
                        </div-->

                        <div class="shop-item__image">
                            <img alt="product" src="/img/tmp/product-large-5.jpg">
                        </div>
                        <div class="shop-item__title">
                            <h5><?=$ch->name?></h5>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </section>
<?php } elseif($item === 3) { ?>
    <main class="container" >
        <h3 style="margin:30px 0;text-align:center;font-style: italic;font-size: 30px;opacity: 0.7;">Подкатегории</h3>
        <div class="row" id="sub_categories">
            <?php foreach($model->children as $ch) {?>
                <div class="col-md-4 col-xs-6 main_info_wide_grid" >
                    <a href="<?='/category/'.($ch->seoTags->slug == null ? $ch->id : $ch->seoTags->slug)?>" class="">
                        <div class="hover-element hover-element-1 row">
                            <div class="hover-element__initial">
                                <img alt="Pic" src="/img/tmp/work6.jpg">
                                <h4 class="unElement"><?=$ch->name?></h4>
                            </div>
                            <div class="hover-element__reveal" data-overlay="9">
                                <div class="boxed">
                                    <?php if (!empty($ch->description)){ ?>
                                        <span>
                                    <em>Описание:</em>
                                </span>
                                    <?php } ?>
                                    <?=$ch->description?>
                                </div>
                            </div>
                        </div>

                    </a>
                </div>
            <?php } ?>
        </div>
    </main>
<?php } else { ?>
    <main class="container">
        <h2 style="margin:30px 0; text-align:center;">Подкатегории</h2>
        <div class="row">
            <?php foreach($model->children as $ch) {?>
                <a href="<?='/category/'.($ch->seoTags->slug == null ? $ch->id : $ch->seoTags->slug)?>" class="col-xs-12">
                    <div class="card card--horizontal card-5">
                        <div class="card__image col-sm-7 col-md-8">
                            <div class="background-image-holder" style="background: url('/img/tmp/work18.jpg'); opacity: 1;">
                                <img alt="Pic" src="/img/tmp/work18.jpg">
                            </div>
                        </div>
                        <div class="card__body col-sm-5 col-md-4 boxed boxed--lg bg--white">
                            <div class="card__title">
                                <h3><?=$ch->name?></h3>
                            </div>
                            <div class="description_sub_cat">
                                <?=$ch->description?>
                            </div>

                            <!--span>
                                <em>Digital Storefront</em>
                            </span>
                            <p>
                                Sticky note agile personas engaging ship it ideate disrupt earned media.
                            </p-->
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </main>
<?php } ?>
<?php foreach($products as $k=>$p): ?>
    <!--div class="col-sm-6 col-md-4 col-lg-3 h350">
        <a href="/product/<?=$p->seoTags->slug?>" class="item-img"><img alt="<?=$p->name?>" title="<?=$p->name?>" src="<? //=$p->mainimage->thumb(200)?>"></a>
        <a href="/product/<?=$p->seoTags->slug?>" class="title"><?=$p->name?></a>
        <div class="col-sm-12 center-block nopadding">
            <div class="item-price"><?=$p->price?> Р</div>
            <a class="item-basket" data-id="<?=$p->id?>">В корзину</a>
        </div>
    </div-->
<?php endforeach; ?>



