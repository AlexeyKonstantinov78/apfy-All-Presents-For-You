<?php
use app\modules\shop\models\Product;
use app\assets\ItemAsset;
use app\assets\FancyAsset;
use app\assets\OwlAsset;
//use app\models\BreadcrumbsMicro;
//use yii\widgets\Breadcrumbs;
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
//fancybox
if($(window).width() > 991){
    $(function(){
        var itemObj = [];
        $.each($('#item_images img'), function(k,v) {
            /*
            itemObj.push({
                href: $(v).data('href'),
                //title: 'test'
            });
            */
            itemObj[Number($(v).data('index'))]={href: $(v).data('href')};
            //console.log(itemObj);
        });

        $('#item_image').on('click', 'img', function () {
            var ind = $(this).data('index');
            $.fancybox.open(itemObj, {
                padding : 0,
                autoResize: false,
                autoSize: false,
                autoHeight: false,
                maxWidth: 900,
                index: ind,
                //type: 'image',
            });
            return false;
        });
    });

}
$('button.halvaItems').on('click', function(){
    $('.halvaItemsDesc').toggle('slow');
});
$('.fancy_a').fancybox({
    type: 'ajax'
})
//изменение главной картинки товара
$('#item_images ').on('click', '.item_img', function(){
    var d = $(this);
    $('#item_image').fadeOut('fast', function(){
        $(this).html('<img src=\"'+d.data('href')+'\" alt=\"'+d.attr('alt')+'\" data-index=\"'+d.data('index')+'\">')
    }).fadeIn('fast');
});
//кнопки добавление и удаления
$('.item_quant').on('click', function () {
    var action = $(this).data('action'),
        quant = Number($('#item_quant').val());
    if(action == 'add')
        $('#item_quant').val(quant+1);
    if(action == 'delete' && quant>1)
        $('#item_quant').val(quant-1);
});
$('#item_quant').on('change', function(){
    if(isNaN(Number($(this).val())) == true || Number($(this).val()) < 1)
        $('#item_quant').val('1');
});
    $('#item .item_info_block .owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        autoplay: true,
        autoplayTimeout: 5000,
        navSpeed: 2000,
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
        item_imgs.on('translated.owl.carousel', function(event) {
            //console.log(event);
            //console.log($('#item_image').find('.active').first().find('.item_img').data('href'));
            //var img = item_imgs.find('.active').first().find('.item_img').data('href');
            //var img = $('#item_images .owl-carousel .owl-stage .active').first().find('.item_img').data('href');
            var img = $('#item_images .owl-carousel .owl-stage .active.center .item_img').data('href');
            var ind = $('#item_images .owl-carousel .owl-stage .active.center .item_img').data('index');
            //console.log(img);
            if($(window).width() <= '992'){
                $('#item_images .owl-carousel .owl-stage .active.center .item_img img').attr('src', img);
            } else {
                $('#item_image img').attr('src', img);
                $('#item_image img').data('index', ind);
            }
            
        });
        if($(window).width() <= '992'){
            $('#item_images .owl-carousel .owl-stage .active.center .item_img img').attr('src', $('#item_images .owl-carousel .owl-stage .active.center .item_img').data('href'));
        } 
    ";

else:
$js = "
if($(window).width() <= '992'){
        $('#item_images .owl-carousel .item_img img').attr('src', $('#item_images .owl-carousel .item_img').data('href'));
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
$links = [];
if(isset($_GET['deb'])){
    if(isset(Yii::$app->params['breadcrumbs'])) {
        foreach (Yii::$app->params['breadcrumbs'] as $ind => $bread) {
            $url = isset($bread['url'][0]) ? $bread['url'][0] : $_SERVER['REQUEST_URI'];
            if(isset($bread['url'][0]))
                $links[] = [
                    'label' => $bread['label'],
                    'url' => $url,
                    'template' => "<li itemprop=\"itemListElement\" itemscope itemtype=\"http://schema.org/ListItem\"><a itemscope itemtype=\"http://schema.org/Thing\" itemprop=\"item\" href='https://apfy.ru" . $url . "'><span itemprop='name'>" . $bread['label'] . "</span><meta itemprop='position' content=".($ind+1)."></a><span class=\"itemSeparator\">/</span></li>", // template for this link only
                ];
            else
                $links[] = [
                    'label' => $bread['label'],
                    'template' => "<span itemprop='name'>" . $bread['label'] . "</span>", // template for this link only
                ];
        }
    }
}
?>
<?php
//$cost = $model->discount_price > 0 ? $model->discount_price : $model->price;
$discount = '';
if($model->discount_price > 0)
    $discount = '
        ,"sale_price": "'.$model->discount_price.'.00"
    ';
$item = '<script type="application/ld+json">
{
    "@context" : "http://schema.org",
    "@type" : "Product",
    "url" : "'.$_SERVER['REQUEST_URI'].'",
    "name" : "'.$model->name.'",
    "image" : "https://apfy.ru/'.$model->mainImage->image.'",
    "description" : "'.$model->description.'",
    "category": "'.Yii::$app->params['breadcrumbs'][count(Yii::$app->params['breadcrumbs'])-1]['label'].'",
    "sku": "'.$model->artid.'",
    "gtin14": "'.str_pad($model->gtin,  14, "0", STR_PAD_LEFT).'",
    "brand" : {
        "@type" : "Brand",
        "name" : "'.$brand->name.'"
    },
    "offers": {
        "@type": "Offer",
        "availability": "https://schema.org/InStock",
        //"itemCondition": "http://schema.org/NewCondition",
        "priceSpecification": {
            "@type":  "PriceSpecification",
            "priceCurrency": "RUB",
            "price" : "'.$model->price.'.00"
            '.$discount.'
        }
    }
    /*
    "offers" : {
        "@type" : "Offer",
        "priceCurrency": "RUB",
        "availability": "https://schema.org/InStock",
        "itemCondition": "http://schema.org/NewCondition",
        "price" : "'.$model->price.'.00",
        "priceSpecification": {
            "@type":  "PriceSpecification",
            "salePrice": {
                "@type" : "Text",
                "value": "1500.00",
                "currency": "RUB"
            }
        }
    }
    */
}
</script>';
echo $item;
//*/
?>
<?php $model->name = empty($model->seoTags->h1) ? $model->name : $model->seoTags->h1; ?>
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

<main class="container" id="item">
    <section itemscope itemtype="http://schema.org/Product">
        <div class="row">
            <section class="col-xs-12 text-center">
                <h1 class="h3" itemprop="name"><?=$model->name?></h1>
                <?php if($brand !== null): ?><meta itemprop="alternateName" content="<?=$brand->name?> - <?=$model->artid?>." /><?php endif; ?>
            </section>
            <hr class="gold_hr" style="margin-top: 15px; margin-bottom: 15px" />
        </div>
        <div class="row">
            <?php if($model->mainImage != null): ?>
            <div class="col-md-7">
                <?php if(!empty($model->discount_price) && $model->discount_price>0) : ?>
                    <?php if($model->discount_price > 5000 && isset($gen)): ?>
                        <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
                    <?php endif; ?>
                <?php elseif ($model->price > 5000): ?>
                    <a href="https://apfy.ru/articles/novosti/akciya" target="_blank" class="stock_present" title="+ Подарок!"><span >+ Подарок!</span></a>
                <?php endif; ?>
                <meta itemprop="image" content="https://apfy.ru<?=$model->mainImage->image?>" />
                <section id="item_image" class="text-center">
                    <img src="<?=$model->mainImage->thumb(null, 600)?>" class="gal" data-fancybox-group="gal"  data-index="0" alt="<?=$model->name?>">
                </section>
                <?php if(count($images)>0): ?>
                    <section id="item_images">
                        <div class="owl-carousel text-center owl_nav">
                            <?php $ind = 0; ?>
                            <?php foreach($images as $k=>$v): ?>
                                <?php if($v->is_main == 1) Continue?>
                                <?php //if($this->isMobile): var_dump($this->isMobile); var_dump($this->isTablet); exit; ?>
                                <?php //endif; ?>
                                <div class="item_img" data-index="<?=$ind?>" data-href="<?=Image::thumb($v->image, 900)?>">
                                    <img src="<?=Image::thumb($v->image, null, 80)?>" data-href="<?=Image::thumb($v->image, 900)?>" data-index="<?=$ind?>" alt="<?=$v->alt?>" >
                                </div>
                                <?php ++$ind; ?>
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
                    <p><b class="text-uppercase">Доставка по всей России!</b> <a class="fancy_a transition_02" href="/page/delivery">Подробнее о доставке здесь.</a></p>
					<button class="halvaItems none_outline"><img src="/img/site/halva/order_product/toggle.jpg" alt="Рассрочка 4 месяца по крарте Халвы!" /></button>
                    <!--p class="text-center">
                        <a href="/articles/novosti/20-sikdka-na-tovary-parker-i-waterman" target="_blank">
                            <img src="/uploads/other_images/bannerrs/halvaFull.jpg" alt="20% сикдка на товары Parker и Waterman" style="width: 60%; display: inline-block;"/>
                        </a>
                    </p-->
					<div class="halvaItemsDesc">
						<p>Здесь можно расплатиться Халвой! <a href="/page/karta-halva" class="fancy_a transition_02">Побробнее...</a></p>
					</div>
                </section>
            </div>
            <div class="col-md-5 ">
                <?php else: ?>
                <div class="col-xs-12">
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <section class="item_price text-right" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                <meta itemprop="priceCurrency" content="RUB" />
                                <meta itemprop="availability" href="http://schema.org/InStock" content="in stock" />
                                <?php if($model->active == 1): ?>
                                    <span class="item_stock item_stock_green1" style="float:left"><!--Есть в наличии--></span>
                                <?php else: ?>
                                    <span class="item_stock item_stock_red1" style="float:left"><!--Под заказ--></span>
                                <?php endif; ?>
                                <?php if(!empty($model->discount_price) && $model->discount_price>0): ?>
                                    <span class="item_price_number general_item_price_dis" itemprop="sale_price" content="<?=$model->discount_price?>.00">
                                        <?=number_format($model->discount_price,0,'',' ');?>
                                    </span> <span class="general_item_price_dis">руб.</span>
                                    <span class="general_item_price_discount" itemprop="price" content="<?=$model->price?>.00">
                                        <?=number_format($model->price,0,'',' ');?>
                                        <span class="general_item_currency">руб.</span>
                                    </span>
                                <?php else: ?>
                                    <span class="item_price_number" itemprop="price" content="<?=$model->price?>.00">
                                        <?=number_format($model->price,0,'',' ');?>
                                    </span> руб.
                                <?php endif; ?>
                            </section>
                        </div>
                        <div class="col-xs-12">
                            <?php if($model->active == 1): ?>
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
                                </div>
                            <?php else: ?>
                                <div class="row input_panel clear">
                                    <div class="col-xs-12 input_panel_section">
                                        <button class="black_white_form white_el general_item_order_under text-center text-uppercase transition_02" data-id="<?=$model->id?>" style="width:100%">
                                            Узнать о поступлении!
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <hr class="gold_hr" style="margin-top: 15px; margin-bottom: 15px; display: block !important;" />
                        </div>
                        <div class="col-md-12 col-sm-8 col-xs-12" >
                            <section class="attributes">
                                <?php if($brand !== null): ?><p><b>Бренд</b>: <span itemprop="brand"><?=$brand->name?></span></p><?php endif; ?>
                                <?php if(count($model->productAttributesList)>0): ?>
                                    <?php foreach($model->productAttributesList as $k=>$v) : ?>
                                        <p><b><?=$v->productAttribute->name?></b>: <?=$v->value?></p>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <article class="text-left font_weight_300" itemprop="description">
                                    <?=$model->description?>
                                </article>
                                <meta itemprop="gtin14" content="<?=str_pad($model->gtin,  14, "0", STR_PAD_LEFT)?>"  />
                                <meta itemprop="sku" content="<?=$model->artid?>" />
                                <?php
                                //                            var_dump(Yii::$app->params['breadcrumbs']);
                                //                            exit;
                                //echo Yii::$app->params['breadcrumbs'][count(Yii::$app->params['breadcrumbs'])-1]['label'];
                                ?>
                                <meta itemprop="category" content="<?=Yii::$app->params['breadcrumbs'][count(Yii::$app->params['breadcrumbs'])-1]['label']?>" />
                                <meta itemprop="weight" content="<?=$model->weight?>" />
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                                <?php if($p->discount_price > 5000 && isset($gen)): ?>
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
<!-- Разметка JSON-LD, созданная Мастером разметки структурированных данных Google. -->


