<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
//use yii\widgets\Breadcrumbs;
//use yii\bootstrap\Modal;
//use app\modules\shop\models\Cart;
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
        <link rel="shortcut icon" href="/favicon.ico" sizes="16x16">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php AppAsset::register($this); ?>
        <?php $this->head() ?>
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter48282563 = new Ya.Metrika({
                            id:48282563,
                            clickmap:true,
                            trackLinks:true,
                            accurateTrackBounce:true,
                            webvisor:true
                        });
                    } catch(e) { }
                });

                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = "https://mc.yandex.ru/metrika/watch.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else { f(); }
            })(document, window, "yandex_metrika_callbacks");
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/48282563" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->

        <script type="text/javascript">
            var google_conversion_id = 812712861;
            var google_conversion_label = "0OGuCIHa8X4QnYfEgwM";
        </script>
        <script type="text/javascript" src="//autocontext.begun.ru/conversion.js"></script>
        <!-- Traffic tracking code -->
        <script type="text/javascript">
            (function(w, p) {
                var a, s;
                (w[p] = w[p] || []).push({
                    counter_id: 507240249
                });
                a = document.createElement('script'); a.type = 'text/javascript'; a.async = true;
                a.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'autocontext.begun.ru/analytics.js';
                s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(a, s);
            })(window, 'begun_analytics_params');
        </script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-99355892-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-99355892-1');
        </script>
        <!-- Global site tag (gtag.js) - Google Ads: 986682015 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-986682015"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'AW-986682015');
        </script>

        <?php if(Yii::$app->controller->route =='shop/cart/result'): ?>
            <!-- Event snippet for Оформление заказа conversion page -->
            <script>
                gtag('event', 'conversion', {
                    'send_to': 'AW-986682015/doAVCMfTgY0BEJ-lvtYD',
                    'value': total,
                    'currency': 'RUB',
                    'transaction_id': id
                });
            </script>
        <?php endif; ?>

        <!-- Event snippet for Клик по телефону в мобильном conversion page
    In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
        <script>
            function gtag_report_conversion(url) {
                var callback = function () {
                    if (typeof(url) != 'undefined') {
                        window.location = url;
                    }
                };
                gtag('event', 'conversion', {
                    'send_to': 'AW-986682015/9uUOCJv1gY0BEJ-lvtYD',
                    'event_callback': callback
                });
                return false;
            }
        </script>

        <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-360774-7JFIc"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-360774-7JFIc" style="position:fixed; left:-999px;" alt=""/></noscript>
        <!--  -->

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

    <?= $content ?>

    <?php //подумать над отображением адреса to look ?>
    <?php //подумать на счет конвертации в свг всего что только можно to look ?>
    <footer class="" itemscope itemtype="http://schema.org/Organization">
        <section class="container">
            <div class="row footer_info">
                <div class="col-xs-12 col-sm-6">
                    <div class="row">
                        <div class="col-xs-12" itemprop="address" itemscope
                             itemtype="http://schema.org/PostalAddress">
                            Адрес:
                            <span itemprop="addressLocality">г. Москва</span>,
                            <span itemprop="postalCode"> 115088</span>,
                            <span itemprop="streetAddress">ул. Шарикоподшипниковская, д. 13, стр. 24 (склад)</span>
                        </div>
                        <div class="col-xs-12">
                            <a class="transition_02 footer_link" href="/page/polzovatelskoe-soglashenie">Пользовательское соглашение</a>
                            <br/><a class="transition_02 footer_link"target="_blank" href="/page/politika-konfidencialnosti">Политика конфиденциальности</a>
                            <!--                        <br/><a href="https://vk.com/biznes_podarki_apfy" title="Бизнес-подарки"><img src="/img/site/icons/vk_icon.png" style="max-width: 52px; width:100%" alt="Бизнес-подарки" /></a>-->
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6  text-right">
                    <a href="https://vk.com/biznes_podarki_apfy" title="Бизнес-подарки" target="_blank"><img src="/img/site/icons/vk_icon.png" style="max-width: 44px; width:100%" alt="Бизнес-подарки" /></a><br/>
                    <img src="/img/site/icons/AlfaBank.png" style="max-width: 87px; width:100%" alt="Банковская система Альфа-Банк" />
                    <img src="/img/site/icons/carts.png" style="max-width: 200px; width:100%" alt="Принимаем карты: Visa, Maestro, MasterCart, Мир">
                    <a href="/page/karta-halva" style="margin: 5px; display:inline-block"><img src="/img/site/halva/cart/cartSize.png" alt="Прием карт халвы" /></a>
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
                        <a itemprop="telephone" class="g_phone"  onclick="goog_report_conversion ('tel:8 (495) 199-18-25')" href="tel:+7 495 199 18 25">+7 495 199 18 25</a>
                        <span class="hidden-xs">/</span>
                        <a itemprop="email" class="g_mail" href="mail:info@apfy
                    .ru">info@apfy.ru</a>
                    </div>

                    <!--div class="col-md-4 col-xs-3 soc_icon">
                        <a href="#"><img src="/img/site/icon_in_svg/fb.png" alt="" /></a>
                        <a href="#"><img src="/img/site/icon_in_svg/od.png" alt="" /></a>
                        <a href="#"><img src="/img/site/icon_in_svg/vk.png" alt="" /></a>
                    </div-->
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

    </body>
</html>

<?php $this->endBody() ?>
<?php $this->endPage() ?>
<?php
//<!-- RedHelper -->
//<script id="rhlpscrtg" type="text/javascript" charset="utf-8" async="async"
//        src="https://web.redhelper.ru/service/main.js?c=apfyru">
//</script>
//<!--/Redhelper -->
?>