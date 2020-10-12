<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
//use yii\widgets\Breadcrumbs;
//use yii\bootstrap\Modal;
//use app\modules\shop\models\Cart;

$this->registerCssFile('/css/site/pagesCss/cabinet.css');
use app\assets\AppAsset;
use app\widgets\menu\MenuWidget;
use app\widgets\cart\CartWidget;
use app\widgets\html\HtmlWidget;
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/img/favicon/favicon.ico" sizes="16x16">
        <link type="image/png" href="/img/favicon/favicon_16.png" rel="icon" sizes="16x16">
        <link type="image/png" href="/img/favicon/favicon_32.png" rel="icon" sizes="32x32">
        <link type="image/png" href="/img/favicon/favicon_96.png" rel="icon" sizes="96x96">
        <link type="image/png" href="/img/favicon/favicon_194.png" rel="icon" sizes="194x194">
        <link type="image/png" href="/img/favicon/android-chrome_192.png" rel="icon" sizes="192x192">
        <link type="image/png" href="/img/favicon/apple-touch-icon_57.png" rel="apple-touch-icon" sizes="57x57">
        <link type="image/png" href="/img/favicon/apple-touch-icon_60.png" rel="apple-touch-icon" sizes="60x60">
        <link type="image/png" href="/img/favicon/apple-touch-icon_72.png" rel="apple-touch-icon" sizes="72x72">
        <link type="image/png" href="/img/favicon/apple-touch-icon_76.png" rel="apple-touch-icon" sizes="76x76">
        <link type="image/png" href="/img/favicon/apple-touch-icon_114.png" rel="apple-touch-icon" sizes="114x114">
        <link type="image/png" href="/img/favicon/apple-touch-icon_120.png" rel="apple-touch-icon" sizes="120x120">
        <link type="image/png" href="/img/favicon/apple-touch-icon_144.png" rel="apple-touch-icon" sizes="144x144">
        <link type="image/png" href="/img/favicon/apple-touch-icon_152.png" rel="apple-touch-icon" sizes="152x152">
        <link type="image/png" href="/img/favicon/apple-touch-icon_180.png" rel="apple-touch-icon" sizes="180x180">
        <link rel="icon" href="/img/favicon/apfy_192.ico" type="image/x-icon">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php AppAsset::register($this); ?>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <section id="top_bar">
        <section class="top_navigation">
            <div class="container">
                <?php if(isset($_GET['deb'])): ?>
                    <?= MenuWidget::widget(['id_menu' => 'main_items', 'tmp_menu' => 'general_site_top_test', 'with_ParentId' => '86'])
                    //если нет with_id, то действует выбирает по with_ParentId (parent_id) ?>
                <?php else: ?>
                    <?= MenuWidget::widget(['id_menu' => 'main_items', 'tmp_menu' => 'general_site_top', 'with_ParentId' => '86'])
                    //если нет with_id, то действует выбирает по with_ParentId (parent_id) ?>
                <?php endif; ?>
                <div class="top_panel">
                    <?php if(isset($_GET['auth'])): ?>
                        <?=HtmlWidget::widget(['tmp' => 'authUsers'])?>
                    <?php endif; ?>
                    <?= CartWidget::widget(['tmp' => 'cart']) //если нет with_id, то действует выбирает по with_ParentId (parent_id) ?>
                    <form class="top_panel_element searching" name="search" id="search" action="/search/">
                        <input type="text" class="none_outline transition_02" name="text" value="<?=\Yii::$app->request->get('query')?>" placeholder="Поиск..." />
                        <button class="none_outline" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
            </div>
        </section>
        <div  class="top_info general_navigation">
            <section class="container">
                <div class="row">
                    <div class="col-md-6 col-xs-6" id="logo">
                        <a href="/" ><img src="/img/site/logo_new.png" alt="Apfy
                    .ru - all presents for you"></a> <small class="hidden-xs"> <span >/</span> All
                            Presents  For  You</small>
                    </div>
                    <div class="col-md-6 col-xs-6 text-right top_phone_mail">
                        <a class="g_phone" onclick="goog_report_conversion ('tel:8 (495) 199-18-25')" href="tel:+74951991825">+7 495 199 18 25</a>
                        <span class="hidden-xs">/</span>
                        <a
                                class="g_mail hidden-xs"
                                href="mail:info@apfy.ru">info@apfy.ru</a>
                        <small class="hidden-sm hidden-lg hidden-md"
                               style="display:block; font-weight: 600"> All
                            Presents  For  You</small>
                    </div>
                    <!--div class="col-md-4 col-xs-3 soc_icon">
                        <a href="#"><img src="/img/site/icon_in_svg/fb.png" alt="" /></a>
                        <a href="#"><img src="/img/site/icon_in_svg/od.png" alt="" /></a>
                        <a href="#"><img src="/img/site/icon_in_svg/vk.png" alt="" /></a>
                    </div-->
                </div>
            </section>
        </div>
    </section>

    <main class="container" style="margin-bottom: 50px">
        <div class="row">
            <section class="col-xs-12 text-center">
                <hr class="gold_hr">
                <h1 class="h2 text-center h_gold">Личный кабинет</h1>
            </section>
        </div>
        <div class="row">
            <section class="col-md-3 col-xs-12">
                <?= HtmlWidget::widget(['tmp' => 'cabinet_menu']) ?>
            </section>
            <section class="col-md-9 col-xs-12">
                <?php
                    echo $content;
                ?>
            </section>
        </div>
    </main>

    <?php //подумать над отображением адреса to look ?>
    <?php //подумать на счет конвертации в свг всего что только можно to look ?>
    <footer class="" itemscope itemtype="http://schema.org/Organization">
        <section class="container">
            <div class="row footer_info">
                <div class="col-xs-6 col-lg-4 footer_info_block">
                    <h4><i class="fa fa-fw fa-book"></i> Информация</h4>
                    <a class="transition_02 footer_link" target="_blank" href="/page/about">
                        О нас
                    </a><br/>
                    <a class="transition_02 footer_link" target="_blank" href="/articles/novosti">
                        Новости
                    </a><br/>
                    <a class="transition_02 footer_link" target="_blank" target="_blank" href="/page/delivery">
                        Доставка и оплата
                    </a><br/>
                    <a class="transition_02 footer_link" target="_blank" href="/page/garantii-i-vozvrat">
                        Гарантии и возврат
                    </a><br/>
                </div>
                <div class="col-xs-6 col-lg-4 footer_info_block">
                    <h4><i class="fa fa-fw fa-external-link"></i> Полезные ссылки</h4>
                    <a class="transition_02 footer_link" target="_blank" href="/page/polzovatelskoe-soglashenie">Пользовательское соглашение</a><br/>
                    <a class="transition_02 footer_link" target="_blank" href="/page/politika-konfidencialnosti">Политика конфиденциальности</a><br/>
                    <a class="transition_02 footer_link" target="_blank" href="/sitemap.xml">Карта сайта</a><br/>
                </div>
                <div class="col-xs-12 col-lg-4 footer_info_block">
                    <h4><i class="fa fa-fw fa-file-text"></i> Гарантии и возврат</h4>
                    <p>APFY.RU является ОФИЦИАЛЬНЫМ ДИЛЕРОМ представленного товара, мы продаем только ОРИГИНАЛЬНУЮ ПРОДУКЦИЮ, сертифицированную в России и имеющую гарантию производителя!</p>
                    <p>Хотите вернуть товар? Вы можете вернуть его в течение 14 дней! <a href="/page/garantii-i-vozvrat" class="transition_02 footer_link" target="_blank">Подробнее</a></p>
                </div>
                <div class="col-xs-12 col-sm-6 footer_info_block">
                    <h4><i class="fa fa-fw fa-phone"></i> Контакты</h4>
                    <div class="row">
                        <div class="col-xs-12" style="margin-bottom: 5px">
                            <b>Время работы:</b> <time
                                    itemprop="openingHours"
                                    datetime="Mo-Su 9:00−20:00">С понедельника по воскресенье c 9:00−20:00
                            </time><br/>
                            <b>Доставка:</b>
                            <span>В рабочие дни с 10:00 до 21:00 (время доставки согласовывается при подтверждении заказа)</span>
                        </div>
                        <div class="col-xs-12">
                            <b>Телефон:</b> <a itemprop="telephone" onclick="goog_report_conversion ('tel:+7(495)199-18-25')" href="tel:+74951991825">+7 495 199 18 25</a>
                        </div>
                        <div class="col-xs-12" itemprop="address" itemscope
                             itemtype="http://schema.org/PostalAddress">
                            <b>Адрес:</b>
                            <span itemprop="addressCountry">Россия</span>,
                            <span itemprop="addressRegion" style="display: none">Москва</span>
                            <span itemprop="addressLocality">г. Москва</span>,
                            <span itemprop="postalCode"> 115088</span>,
                            <span itemprop="streetAddress">ул. Шарикоподшипниковская, д. 13, стр. 24 (склад)</span>
                        </div>
                        <div class="col-xs-12" style="display: none">
                            <a href="https://vk.com/biznes_podarki_apfy" title="Бизнес-подарки" target="_blank"><img src="/img/site/icons/vk_icon.png" style="max-width: 44px; width:100%" alt="Бизнес-подарки" /></a>
                            <a href="https://webmaster.yandex.ru/sqi?host=apfy.ru" style="margin: 5px; display:inline-block"><img width="88" height="31" alt="" border="0" src="https://yandex.ru/cycounter?apfy.ru&theme=light&lang=ru"/></a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 footer_info_block">
                    <h4><i class="fa fa-fw fa-external-link"></i> Оплата</h4>
                    <img src="/img/site/icons/AlfaBank.png" style="max-width: 87px; width:100%" alt="Банковская система Альфа-Банк" />
                    <img src="/img/site/icons/_Visa.png" style="max-width: 80px; width:100%" alt="Принимаем карты - Visa." />
                    <img src="/img/site/icons/_Master.png" style="max-width: 80px; width:100%" alt="Принимаем карты - Maestro." />
                    <img src="/img/site/icons/_Mir.png" style="max-width: 80px; width:100%" alt="Принимаем карты - Мир." />
                    <a href="/page/karta-halva" style="margin: 5px; display:inline-block"><img src="/img/site/halva/cart/cartSize.png" alt="Прием карт халвы" /></a><br/>
                    <a href="https://vk.com/biznes_podarki_apfy" title="Бизнес-подарки" target="_blank"><img src="/img/site/icons/vk_icon.png" style="max-width: 44px; width:100%" alt="Бизнес-подарки" /></a>
                    <a href="https://webmaster.yandex.ru/sqi?host=apfy.ru" style="margin: 5px; display:inline-block"><img width="88" height="31" alt="" border="0" src="https://yandex.ru/cycounter?apfy.ru&theme=light&lang=ru"/></a>
                </div>
            </div>
        </section>

        <div class="top_info general_navigation">
            <section class="container">
                <div class="row">
                    <div class="col-md-6 col-xs-7 logo">
                        <a  itemprop="url" href="/">
                            <img src="/img/site/logo_new.png" alt="Apfy.ru - all presents for you">
                        </a>
                        <span class="hidden-xs">/</span>
                        <small itemprop="name">All Presents  For  You</small>
                    </div>
                    <div class="col-md-6 col-xs-5 text-right top_phone_mail">
                        <a itemprop="telephone" class="g_phone"  onclick="goog_report_conversion ('tel:+74951991825')" href="tel:+74951991825">+7 495 199 18 25</a>
                        <span class="hidden-xs">/</span>
                        <a itemprop="email" class="g_mail" href="mail:info@apfy.ru">info@apfy.ru</a>
                    </div>
                </div>
            </section>
        </div>
        <button id="down_to_up" class="transition_02 img-circle"><i class="fa fa-chevron-up"></i></button>
    </footer>
    <?php
    yii\bootstrap\Modal::begin([
        'headerOptions' => ['id' => 'modalOrderHeader'],
        'id' => 'callbackOrder',
        'size' => 'modal-sm',
        'clientOptions' => ['backdrop' => 'static']
    ]);
    echo "<div id='modalOrder'></div>";
    yii\bootstrap\Modal::end();
    ?>
    <?php
    yii\bootstrap\Modal::begin([
        'headerOptions' => ['id' => 'modalCabinetHeader'],
        'id' => 'callbackCabinet',
        'size' => 'modal-sm',
        'clientOptions' => ['backdrop' => 'static']
    ]); ?>
    <div id='modalCabinetBody'  style="font-size: 14px;">

    </div>
    <?php
    yii\bootstrap\Modal::end();
    ?>
    <style>
        #breadcrumbs {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            font-size: 14px !important;
        }
    </style>
    <?php $this->endBody() ?>
    <?php $this->endPage() ?>
    </body>
</html>


<?php
//<!-- RedHelper -->
//<script id="rhlpscrtg" type="text/javascript" charset="utf-8" async="async"
//        src="https://web.redhelper.ru/service/main.js?c=apfyru">
//</script>
//<!--/Redhelper -->
?>