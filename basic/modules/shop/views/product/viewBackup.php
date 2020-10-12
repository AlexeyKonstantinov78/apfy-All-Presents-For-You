<?php
use app\modules\shop\models\Product;
use app\assets\ItemAsset;
use app\assets\FancyAsset;
use app\assets\OwlAsset;
use yii\widgets\Breadcrumbs;
use app\helpers\Image;

//var_dump(Yii::$app->params['breadcrumbs']);
//var_dump(yii::$app->request->referrer);
//exit;
FancyAsset::register($this);
OwlAsset::register($this);
ItemAsset::register($this);
$this->registerCssFile('/css/site/pagesCss/product.css');


//var_dump($model->productAttributesList[0]->productAttribute);
//exit();
$images = $model->images;
?>
<?php
$jsI="
    $('#item .item_info_block .owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        dots: false,
        center:true,
        navText: ['<i class=\"fa fa-angle-left\" aria-hidden=\"true\"></i>','<i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i>'],
        responsive:{
            0:{
                items:1,
                nav:true,
            },
            768:{
                items:3,
                nav:true,
            },
        }
    })
";
$js='';
if(count($images)>2):
    //to look todo
    /*
     * исправить отображение больших картинок для мобильной версии через пхп и установить DetectMobile
     *
     * */
    $js = "
        var item_imgs = $('#item_images .owl-carousel');
        item_imgs.owlCarousel({
            loop:true,
            margin:16,
            nav:true,
            center: true,
            dots: false,
            navText: ['<i class=\"fa fa-angle-left\" aria-hidden=\"true\"></i>','<i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i>'],
            responsive:{
                0:{
                    items:1,
                    nav:true,
                },
                500:{
                    items:1,
                    nav:true,
                },
                768:{
                    items:1,
                    nav:true,
                },
                992:{
                    items:3,
                    nav:true,
                },
                1200:{
                    items:5,
                    nav:true,
                },
            }
        });
        //item_imgs.on('initialize.owl.carousel', function(event) {
            //console.log(event);
            //console.log($('#item_image').find('.active').first().find('.item_img').data('href'));
            //var img = item_imgs.find('.active').first().find('.item_img').data('href');
            //var img = $('#item_images .owl-carousel .owl-stage .active').first().find('.item_img').data('href');
            //var img = $('#item_images .owl-carousel .owl-stage .active.center .item_img').data('href');
            //console.log(img);
            //$('#item_image img').attr('src', img);
        //})
        item_imgs.on('translated.owl.carousel', function(event) {
            //console.log(event);
            //console.log($('#item_image').find('.active').first().find('.item_img').data('href'));
            //var img = item_imgs.find('.active').first().find('.item_img').data('href');
            //var img = $('#item_images .owl-carousel .owl-stage .active').first().find('.item_img').data('href');
            var img = $('#item_images .owl-carousel .owl-stage .active.center .item_img').data('href');
            //console.log(img);
            if($(window).width() <= '992'){
                $('#item_images .owl-carousel .owl-stage .active.center .item_img img').attr('src', img);
            } else {
                $('#item_image img').attr('src', img);
            }
            
        });
        if($(window).width() <= '992'){
            $('#item_images .owl-carousel .owl-stage .active.center .item_img img').attr('src', $('#item_images .owl-carousel .owl-stage .active.center .item_img').data('href'));
        } 
    ";

endif;
//item_imgs.on('changed.owl.carousel', function(event) {
////            var img = $('#item_images .owl-item.active:first-child').find('.item_img').data('href');
////            console.log($('#item_image .owl-item.active:first-child .item_img').data('href'));
////            console.log($('#item_image .owl-item.active .item_img').data('href'));
//    console.log($('#item_image).find('.owl-item.active:first-child .item_img'));
//            //$('#item_image img').data('src', img);
//        })
$this->registerJs($jsI.$js);

?>
<?php $model->name = empty($model->seoTags->h1) ? $model->name : $model->seoTags->h1; ?>
<div class="container">
    <div class="row">
        <?=Breadcrumbs::widget([
            'homeLink' => [
                'label' => 'Главная',
                'url' => Yii::$app->homeUrl,
            ],
            'itemTemplate' => '{link} <span>/</span>',
            'links' => isset(Yii::$app->params['breadcrumbs']) ? Yii::$app->params['breadcrumbs'] : [],
            'options' => [ 'id' => 'breadcrumbs', 'class' => 'col-xs-12', 'style' => '
    border-bottom: 1px solid #f3eccd;' ],
            'activeItemTemplate' => '{link}',
            'tag' => 'div',
        ])?>
    </div>
</div>

<main class="container" id="item">
    <div class="row">
        <section class="col-xs-12 text-center">
            <h1 class="h3 "><?=$model->name?></h1>
        </section>
        <hr class="gold_hr" style="margin-top: 15px; margin-bottom: 15px" />
    </div>

    <div class="row">
    <?php if($model->mainImage != null): ?>
        <div class="col-md-7">
            <?php if(!empty($model->discount_price) && $model->discount_price>0) : ?>
                <?php if($model->discount_price > 5000): ?>
                    <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
                <?php endif; ?>
            <?php elseif ($model->price > 5000): ?>
                <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
            <?php endif; ?>
            <section id="item_image" class="text-center">
                <img src="<?=$model->mainImage->thumb(null, 600)?>" class="gal" data-fancybox-group="gal" data-fancybox-href="<?=$model->mainImage->thumb(null, 600)?>" alt="<?=$model->name?>">
            </section>
            <?php if(count($images)>0): ?>
                <section id="item_images">
                    <div class="owl-carousel text-center owl_nav">
                    <?php foreach($images as $k=>$v): ?>
                        <?php if($v->is_main == 1) Continue?>
                        <?php //if($this->isMobile): var_dump($this->isMobile); var_dump($this->isTablet); exit; ?>
                        <?php //endif; ?>
                        <div class="item_img" data-href="<?=Image::thumb($v->image, 900)?>">
                            <img src="<?=Image::thumb($v->image, null, 80)?>" data-href="<?=Image::thumb($v->image, 900)?>" alt="<?=$v->alt?>" >
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>
<!--            <article class="text-left font_weight_300">-->
<!--                --><?php //=$model->description?>
<!--            </article>-->
            <section class="info text-center">
                <p><b class="text-uppercase">Остерегайтесь подделок!</b> APFY.RU является <b class="text-uppercase">официальным дилером</b> представленного товара, мы продаем только <b class="text-uppercase">оригинальную продукцию</b>, сертифицированную в России и имеющую гарантию производителя!</p>
<!--                <p><b class="text-uppercase">Доставка по Москве бесплатно</b> от 4000 руб.</p>-->
<!--                <p><b class="text-uppercase">Доставка в другие города</b> ТК СДЭК.</p>-->
                <p><b class="text-uppercase">Доставка по всей России!</b> <a href="/page/delivery">Подробнее о доставке здесь.</a></p>
            </section>
        </div>
        <div class="col-md-5 ">
    <?php else: ?>
        <div class="col-xs-12">
    <?php endif; ?>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <section class="item_price text-right">
                        <?php if(!empty($model->discount_price) && $model->discount_price>0): ?>
                            <span class="item_price_number general_item_price_dis">
                                <?=number_format($model->discount_price,0,'',' ');?>
                            </span> <span class="general_item_price_dis">руб.</span>
                            <span class="general_item_price_discount">
                                        <?=number_format($model->price,0,'',' ');?>
                                <span class="general_item_currency">руб.</span>
                            </span>
                        <?php else: ?>
                            <span class="item_price_number">
                                <?=number_format($model->price,0,'',' ');?>
                            </span> руб.
                        <?php endif; ?>
                    </section>
                </div>
                <div class="col-xs-12">
                    <div class="row input_panel clear">
                        <div class="col-md-5 col-sm-3 input_panel_section">
                            <section class="input-group">
                                <span class="input-group-addon item_quant black_white_form white_el transition_02" data-action="delete">-</span>
                                <input id="item_quant" class="text-center none_outline form-control black_white_form" type="text"  name="item_quant" placeholder="1" value="1" />
                                <span class="input-group-addon item_quant black_white_form white_el transition_02" data-action="add">+</span>
                            </section>
                        </div>
                        <div class="col-md-7 col-sm-4 input_panel_section">
                            <button class="black_white_form white_el general_item_order_fast text-center text-uppercase transition_02" data-id="<?=$model->id?>" style="width:100%">
                                <i class="general_item_icon_fast general_item_icon_fast_1"></i> Быстрый заказ
                            </button>

                        </div>
                        <div class="col-md-12 col-sm-5 input_panel_section">
                            <button class="black_white_form purpule_el gold_hover_el text-center text-uppercase transition_02 general_item_pay item_add_to_order" data-id="<?=$model->id?>" style="width:100%">
                                Добавить в корзину
                            </button>
                        </div>
                        <?php if(isset($_GET['deb'])): ?>
                            <div class="col-md-12 col-sm-5 input_panel_section">
                                <a target="_blank" href="/articles/novosti/nashli-deshevle-snizim-cenu-dlya-vas" class="black_white_form gold_hover_el text-center text-uppercase transition_02" style="width:100%">
                                    Нашли дешевле?!
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <hr class="gold_hr" style="margin-top: 15px; margin-bottom: 15px" />
                </div>
                <div class="col-md-12 col-sm-8 col-xs-12">
                    <section class="attributes">

                        <?php if($brand !== null): ?><p><b>Бренд</b>: <?=$brand->name?></p><?php endif; ?>
                        <?php if(count($model->productAttributesList)>0): ?>
                            <?php foreach($model->productAttributesList as $k=>$v) : ?>
                                <p><b><?=$v->productAttribute->name?></b>: <?=$v->value?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <article class="text-left font_weight_300">
                            <?=$model->description?>
                        </article>
                    </section>
                </div>

            </div>
        </div>
    </div>
        <?php
        $recomends = null;
        if(!is_null($model->category))
            $recomends =	Product::find()->joinWith('category')->where(['id_category'=>$model->category->id_category, 'product.active' => '1'])->with(['seo'])->orderBy(new \yii\db\Expression('RAND()'))->limit(8)->all();
        ?>
        <?php if($recomends !== null):?>
            <div class="row item_info_block">
                <div class="col-xs-12 text-center">
                    <hr class="gold_hr" style="margin-bottom: 36px">
                    <h2 class="h3 h_gold header_light">Мы также рекомендуем</h2>
                </div>

                <div class="col-xs-12">
                    <div class="owl-carousel owl_nav">
                        <?php
                        foreach($recomends as $p):
                            if(!is_object($p->mainimage)) continue;
                        ?>
                            <?php $p->name = empty($p->seoTags->h1) ? $p->name : $p->seoTags->h1; ?>

                            <div class="general_item  transition_02">
                                <?php if(!empty($p->discount_price) && $p->discount_price>0) : ?>
                                    <?php if($p->discount_price > 5000): ?>
                                        <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
                                    <?php endif; ?>
                                <?php elseif ($p->price > 5000): ?>
                                    <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
                                <?php endif; ?>
                                <a href="/product/<?=$p->seoTags->slug?>" title="<?=$p->name?>" class="text-center general_item_img">
                                    <img alt="<?=$p->name?>" src="<?=$p->mainimage->thumb(null, 260)?>">
                                </a>
                                <span class="item_stock clearfix"></span>
                                <div class="general_item_desc">
                                        <a class="transition_02" href="/product/<?=$p->seoTags->slug?>" title="<?=$p->name?>"><?=$p->name?></a>
                                </div>
                                <hr class="gold_hr">
                                <?php if(!empty($p->discount_price) && $p->discount_price>0): ?>
                                    <span class="general_item_price general_item_price_dis" data-price="<?=$p->discount_price?>">
                                        <?=number_format($p->discount_price,0,'',' ');?>
                                        <span class="general_item_currency">руб.</span>
                                    </span>
                                    <span class="general_item_price_discount">
                                        <?=number_format($p->price,0,'',' ');?>
                                        <span class="general_item_currency">руб.</span>
                                    </span>
                                <?php else: ?>
                                    <span class="general_item_price" data-price="<?=$p->price?>">
                                        <?=number_format($p->price,0,'',' ');?>
                                        <span class="general_item_currency">руб.</span>
                                    </span>
                                <?php endif; ?>
                                <div class="general_add">
                                    <span class="general_item_pay add_to_cart red_but transition_02 hover_opaticy" data-id="<?=$p->id?>" data-href="/product/ruchka-sharikovaya-parker-urban-s0767060-night-sky-blue-ct-m-sinie-chernila">Добавить в корзину</span>
                                    <span class="general_item_order_fast general_item_icon hover_opaticy" data-id="<?=$p->id?>" data-toggle="tooltip" title="" data-original-title="Купить в один клик">
                                        <i class="general_item_icon_fast general_item_icon_fast_1"></i>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif;?>
</main>

