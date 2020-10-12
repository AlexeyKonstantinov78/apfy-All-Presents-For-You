<?php
use app\modules\shop\models\Product;
use app\assets\OwlAsset;
OwlAsset::register($this);
$products = Product::find()->joinWith('category')
    ->where(['id_category'=>'390', 'product.active'=>'1' ])
    ->with(['seo'])
    ->orderBy([new \yii\db\Expression('RAND()')])
    ->limit(24)
    ->all();
$productsSales = Product::find()->joinWith('category')
    ->where(['id_category'=>'1146', 'product.active'=>'1' ])
    ->with(['seo'])
    ->orderBy([new \yii\db\Expression('RAND()')])
    ->limit(24)
    ->all();
$this->registerCssFile('/css/site/pagesCss/main.css');
$jsI="
var owlMain=$('#main_items .owl-carousel');  
    owlMain.owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        dots: false,
        autoplayTimeout: 3500,
//        navSpeed: 2000,
//        fluidSpeed: 2000,
//        dotsSpeed: 2000,
//        dragEndSpeed: 2000,
//        autoplayHoverPause: false,
        center:true,
        autoplay: true,
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
        },
    })
var owlMainSales=$('#main_items_sales .owl-carousel');  
    owlMainSales.owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        dots: false,
        autoplayTimeout: 3500,
//        navSpeed: 2000,
//        fluidSpeed: 2000,
//        dotsSpeed: 2000,
//        dragEndSpeed: 2000,
//        autoplayHoverPause: false,
        center:true,
        autoplay: true,
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
        },
    });
    
    var owlHalva=$('.halva .owl-carousel');  
    owlHalva.owlCarousel({
        loop:true,
        margin:0,
        nav:false,
        dots: false,
        autoplayTimeout: 3500,
        autoplay: true,
        items:1,
        autoHeight:true,
        animateOut: 'fadeOut'
    })
    var owlBanner=$('#banners .owl-carousel');  
    owlBanner.owlCarousel({
        loop:true,
        margin:0,
        nav:false,
        dots: false,
        autoplayTimeout: 3500,
        autoplay: true,
        items:1,
        autoHeight:true,
        animateOut: 'fadeOut'
    })
";
$this->registerJs($jsI);
?>
<link href="https://fonts.googleapis.com/css?family=Exo+2:100,500" rel="stylesheet">
<main class="mainOnMain">
    <section class="container-fluid text-uppercase" id="mainCategory">
        <div class="row">
            <a href="/category/nozhi-victorinox" class="col-md-4 col-xs-6 mainCategoryLink mainCategoryHeaderWhite" style="background-image: url('/img/site/mainPage/knife.jpg')">
                <h3 class="mainCategoryHeader text-center">
                    Ножи
                    <small>VICTORINOX</small>
                </h3>
                <span class="mainCategorySpan transition_02">
                    В каталог
                </span>
            </a>
            <a href="/category/pishushchie-instrumenty" class="col-md-4 col-xs-6 mainCategoryLink mainCategoryHeaderBlack" style="background-image: url('/img/site/mainPage/pen.jpg')">
                <h3 class="mainCategoryHeader text-center">
                    Пищущие
                    <small>принадлежности</small>
                </h3>
                <span class="mainCategorySpan transition_02">
                        В каталог
                    </span>
            </a>
            <a href="/category/zazhigalki-i-aksessuary" class="col-md-4 col-xs-6 mainCategoryLink mainCategoryHeaderWhite" style="background-image: url('/img/site/mainPage/zippo.jpg')">
                <h3 class="mainCategoryHeader text-center">
                    Зажигалки
                    <small>и аксессуары </small>
                </h3>
                <span class="mainCategorySpan transition_02">
                        В каталог
                    </span>
            </a>
            <a href="/category/rasprodazha" class="col-md-4 col-xs-6 mainCategoryLink mainCategoryHeaderBlack" style="background-image: url('/img/site/mainPage/new.jpg')">
                <h3 class="mainCategoryHeader text-center">
                    Распродажа!
                    <small>в нашем каталоге</small>
                </h3>
                <span class="mainCategorySpan transition_02" style="border-color:#fff; color: #000;">
                        В каталог
                    </span>
            </a>
            <a href="/category/ryukzaki-sumki-dorozhnye-aksessuary" class="col-md-4 col-xs-6 mainCategoryLink mainCategoryHeaderWhite" style="background-image: url('/img/site/mainPage/bag.jpg')">
                <h3 class="mainCategoryHeader text-center">
                    Рюкзаки, сумки
                    <small>Дорожные аксессуары</small>
                </h3>
                <span class="mainCategorySpan transition_02">
                        В каталог
                    </span>
            </a>
            <a href="/category/tovary-dlya-aktivnogo-otdyha" class="col-md-4 col-xs-6 mainCategoryLink mainCategoryHeaderBlack" style="background-image: url('/img/site/mainPage/outdoor.jpg')">
                <h3 class="mainCategoryHeader text-center">
                    Outdoor
                    <small>товары для активного отдыха</small>
                </h3>
                <span class="mainCategorySpan transition_02">
                        В каталог
                    </span>
            </a>
        </div>
    </section>
<?php if(count($productsSales)>0): ?>
    <section class="container owlMainSlider" id="main_items_sales">
        <div class="row">
            <div class="col-xs-12 text-center">
                <hr class="gold_hr"/>
                <h3 class="h1 h_gold"><a href="/category/rasprodazha" class="transition_02" style="color:#e30000 !important">Распродажа!</a></h3>
            </div>
        </div>
        <section class="items row">
            <div class="col-xs-12">
                <div class="owl-carousel owl_nav">
                    <?php
                    foreach($productsSales as $p):
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
            <?php

            ?>

        </section>
    </section>
<?php endif; ?>
<?php if(count($products)>0): ?>
    <section class="container owlMainSlider" id="main_items">
        <div class="row">
            <div class="col-xs-12 text-center">
                <hr class="gold_hr"/>
                <h3 class="h1 h_gold"><a href="/category/novinki" class="transition_02">Новинки!</a></h3>
            </div>
        </div>
        <section class="items row">
            <div class="col-xs-12">
                <div class="owl-carousel owl_nav">
                    <?php
                    foreach($products as $p):
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
            <?php
            /*
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="general_item  transition_02" data-itemid="12">
                    <div class="text-center">
                        <img alt="Ручка роллер Waterman Perspective (S0831420) Champagne CT F черные чернила"
                             src="https://apfy.ru/_uploads/tovarnyj_klassifikator/pishuschie_instrumenty/Waterman/Rollery/S0831420_Perspective/S0831420-1-6c32f9.jpg">
                    </div>
                    <span class="item_stock item_stock_1 clearfix">На складе</span>
                    <div class="general_item_desc">
                        <p>Ручка роллер Parker IM Premium (1931686) Grey GT F черные чернила</p>
                    </div>
                    <hr class="gold_hr"/>
                    <span class="general_item_price" data-price="1690">
                        1 690
                        <span class="general_item_currency">руб.</span>
                    </span>
                    <div class="general_add">
                        <span class="general_item_pay red_but
                        transition_02 hover_opaticy" >Купить</span>
                        <span class="general_item_order_fast
                        general_item_icon hover_opaticy"><i class="fa
                        fa-plus-square-o" aria-hidden="true"></i></span>
                        <span class="general_item_favorite general_item_icon hover_opaticy
"><i class="fa
                        fa-heart" aria-hidden="true"></i></span>
                        <span class="general_item_compare general_item_icon hover_opaticy
"><i class="fa
                        fa-columns" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
			https://halvacard.ru/order/?utm_source=MGCom&utm_medium=PKW&utm_campaign=YandexDirect&utm_content=brand_halva_msk_search&utm_term=PKW_P_MG_26296364,2554023959,3970379477,9275730414,none,search,premium,1,%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0,%D0%BA%D0%B0%D1%80%D1%82%D0%B0%20%D1%85%D0%B0%D0%BB%D0%B2%D0%B0,,no,desktop,0&yclid=5667967641215312032
            */
            ?>

        </section>
    </section>
<?php endif; ?>
        <section class="container banners halva">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <hr class="gold_hr"/>
                    <h3 class="h1 h_gold">Халва с нами!</h3>
                </div>
                <div class="col-xs-12">
                    <div class="owl-carousel">
                        <div class="item text-center">
                            <a target="_blank" href="https://app.halvacard.ru/order/?utm_medium=Partner&amp;utm_source=28037141&amp;utm_campaign=halva" title="0% рассрочки"><img src="/img/site/halva/owl/1.jpg" alt="0% рассрочки"></a>
                        </div>
                        <div class="item text-center">
                            <a target="_blank" href="https://app.halvacard.ru/order/?utm_medium=Partner&amp;utm_source=28037141&amp;utm_campaign=halva" title="Халва - все, что нужно для покупок"><img src="/img/site/halva/owl/2.jpg" alt="Халва - все, что нужно для покупок"></a>
                        </div>
                        <div class="item text-center">
                            <a target="_blank" href="https://app.halvacard.ru/order/?utm_medium=Partner&amp;utm_source=28037141&amp;utm_campaign=halva" title="Условия использования халвы"><img src="/img/site/halva/owl/3.jpg" target="_blank" alt="Условия использования халвы"></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <section class="container banners" id="banners">
        <div class="row">
            <div class="col-xs-12 text-center">
                <hr class="gold_hr"/>
                <h3 class="h1 h_gold">Рекомендуем</h3>
            </div>
             <div class="col-xs-12">
                 <div class="owl-carousel">
                     <div class="item text-center">
                         <a href="/category/ryukzaki-sumki-dorozhnye-aksessuary-piquadro" class="container-fluid col-xs-12">
                             <img src="/img/site/mainPage/piquadro.jpg" alt="Piquadro в Москве" />
                         </a>
                     </div>
                     <div class="item text-center">
                         <a href="/category/pishushchie-instrumenty-cross" class="container-fluid col-xs-12">
                             <img src="/img/site/cross.png" alt="баннер" />
                         </a>
                     </div>
                 </div>
             </div>

        </div>
    </section>

    <section class="container article" >
        <div class="row">
            <article class="col-xs-12 text-center">
                <hr class="gold_hr"/>
                <h1 class="h1 h_gold">Интернет-магазин APFY</h1>
                <div class="cols_2_description text-left first_p">
                    <p>
                        <b>APFY.RU — магазин правильных подарков</b>
                    </p><p>В интернет-магазине APFY.RU собраны стильные и практичные подарки. Мы отобрали их с душой,
                        руководствуясь собственным вкусом и многолетним опытом работы на рынке деловых
                        аксессуаров. Основу ассортимента магазина составляет продукция крупнейших мировых брендов:
                        <b>Parker, Waterman, Pelikan, Pierre Cardin, Victorinox, Zippo, Wenger, Piquadro, Leatherman, Thermos и
                            других</b>. Каталог постоянно пополняется новыми наименованиями, среди которых есть и товары
                        для путешествий и активного отдыха.
                    </p><p>
                        Наша цель — облегчить Вам процесс выбора достойного подарка. Для этого на сайте представлен
                        удобный каталог, в котором легко найти всё необходимое. В каждом разделе реализован поиск
                        по Вашим индивидуальным параметрам. Подбор презента потребует от Вас минимум времени и
                        сил. Более того, этот увлекательный процесс доставит Вам колоссальное удовольствие.
                    </p>
                    <p>
                        В нашем магазине нет ничего лишнего — только качественные подарки. Мы отдаем предпочтение
                        премиальным статусным вещам, таким как ручки Parker и аксессуары и сумки Piquadro. Они
                        вызывают восторг, дарят радость и хранят добрую память о человеке. Все, что нужно — выбрать
                        свой стиль и оформить заказ.
                    </p>
                    <p>
                        <b>All Presents For You: делайте подарки себе и близким в интернет-магазине APFY!</b>
                    </p>

                </div>
            </article>
        </div>
    </section>
</main>