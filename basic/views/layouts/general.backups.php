<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Modal;
use app\assets\AppAsset;
use app\widgets\menu\MenuWidget;
use app\widgets\cart\CartWidget;


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <?= MenuWidget::widget(['id_menu' => 'main_items', 'tmp_menu' => 'general_site_top', 'with_ParentId' => '86'])
            //если нет with_id, то действует выбирает по with_ParentId (parent_id) ?>
            <div class="top_panel">
                <section class="top_panel_element display_none" id="auth_top">
                    <button type="button" class="transition_02 none_outline all_collapse_head" data-toggle="collapse" data-parent="#top_bar" data-target="#auth_top_form" aria-expanded="false" aria-controls="auth_top_form">
                        <img src="/img/site/icon_in_svg/auth.png" alt="Авторизация"/>
                    </button>
                    <form class="collapse" id="auth_top_form">
                        <span class="head_auth">Войти в личный кабинет</span>
                        <input type="text" class="input_auth_top none_outline" placeholder="Логин"/>
                        <input type="text" class="input_auth_top none_outline" placeholder="Пароль"/>
                        <div class="clearfix" style="margin-bottom: 30px">
                            <button class="none_outline gen_but" type="submit">Войти</button>
                            <a href="#" class="pull-right gen_a"><span>Регистрация</span></a>
                        </div>
                    </form>
                </section>
                <?= CartWidget::widget(['tmp' => 'cart']) //если нет with_id, то действует выбирает по with_ParentId (parent_id) ?>
                <form class="top_panel_element hidden-xs hidden-sm" id="search">
                    <input type="text" class="none_outline transition_02" placeholder="Поиск..." /><button class="none_outline" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </section>
    <div  class="top_info general_navigation">
        <section class="container">
            <div class="row">
                <div class="col-md-6 col-xs-6" id="logo">
                    <a href="/" ><img src="/img/site/logo_new.png" alt="Apfy
                    .ru - all present for you"></a> <small class="hidden-xs"> <span >/</span> All
                        Present  For  You</small>
                </div>
                <div class="col-md-6 col-xs-6 text-right top_phone_mail">
                    <a class="g_phone" href="tel:+7 900 444 22 33">+7 900 444
                        22 33</a>
                    <span class="hidden-xs">/</span>
                    <a
                            class="g_mail hidden-xs"
                            href="mail:info@apfy.ru">info@apfy.ru</a>
                    <small class="hidden-sm hidden-lg hidden-md"
                           style="display:block"> All
                        Present  For  You</small>
                </div>
            </div>
        </section>
    </div>
</section>

<?= $content ?>
<footer class="" itemscope itemtype="http://schema.org/Organization">
    <section class="container">
        <div class="row footer_info">
            <div class="col-xs-6" itemprop="address" itemscope
                 itemtype="http://schema
            .org/PostalAddress">
                Адрес:
                <span itemprop="streetAddress">Льва Толстого, 16</span>
                <span itemprop="postalCode"> 119021</span>
                <span itemprop="addressLocality">Москва</span>,
            </div>
        </div>
    </section>
    <div class="top_info general_navigation">
        <section class="container">
            <div class="row">
                <div class="col-md-6 col-xs-6 logo">
                    <a  itemprop="url" href="/">
                        <img src="/img/site/logo_new.png" alt="Apfy.ru - all present for you">
                    </a>
                    <span class="hidden-xs">/</span>
                    <small itemprop="name">All Present  For  You</small>
                </div>
                <div class="col-md-6 col-xs-6 text-right top_phone_mail">
                    <a itemprop="telephone" class="g_phone" href="tel:+7 900
                    444 22 33">+7 900 444
                        22 33</a>
                    <span class="hidden-xs">/</span>
                    <a itemprop="email" class="g_mail" href="mail:info@apfy
                    .ru">info@apfy.ru</a>
                </div>
            </div>
        </section>
    </div>
</footer>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalOrderHeader'],
    'id' => 'callbackOrder',
    'size' => 'modal-sm',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalOrder'></div>";
yii\bootstrap\Modal::end();
?>


<style>
#top_bar {
position:absolute;
z-index:99;
background:url(/img/site/bg_header.jpg) top center no-repeat;
}

.top_navigation nav ul {
list-style-type:none;
}

.top_navigation .main_menu li a {
color:#edda80;
text-decoration:none;
}

.top_navigation .main_menu > li > a:hover,.top_navigation .main_menu > li > a.list_catalog,.top_navigation .main_menu > li > a.collapsed.list_catalog:hover {
background-color:rgba(236,217,126,0.1);
}

#collapseMenu_1 {
z-index:9999;
width:100%;
left:0;
}

#collapseMenu_1 li {
display:list-item;
}

#collapseMenu_1 a {
display:block;
}

.general_navigation {
background-color:rgba(240,222,134,1);
padding-top:12px;
padding-bottom:12px;
}

.gen_a span {
border-bottom:dotted 1px #858586;
}

.gen_a {
color:#858586;
text-decoration:none!important;
font-size:13px;
}

.gen_a:hover {
color:#CECECF;
}

.gen_but {
min-width:100px!important;
font-size:13px!important;
line-height:36px!important;
height:36px!important;
background:#ac1068!important;
display:inline-block;
color:#fff!important;
}

#auth_top_form {
background-color:#29292a;
text-align:left;
z-index:999;
width:290px;
position:absolute;
left:inherit;
right:0;
top:56px;
padding:0 20px;
}

.head_auth {
color:#fff;
display:block;
font-size:16px;
line-height:56px;
margin-bottom:12px;
}

#cart > button > small {
background-color:#ac1068;
color:#fff;
display:block;
position:absolute;
-webkit-border-radius:7px;
-moz-border-radius:7px;
border-radius:7px;
line-height:14px;
width:14px;
font-size:9px;
top:14px;
right:14px;
}

#items {
overflow-y:auto;
max-height:calc(100vh-220px);
}

#items .item:last-child {
border-bottom:none!important;
}

#items .item_href {
color:#fff!important;
line-height:16px;
display:block;
font-size:11px;
text-decoration:none!important;
}

#items .item_change_quant.quant_add_to {
margin-left:0!important;
}

.cart_item_price {
color:#858586;
line-height:20px;
font-size:14px;
margin-top:12px;
}

.total_cost {
background-color:#3f3f40;
line-height:20px;
color:#858586;
font-size:16px;
padding:0 24px;
}

#total_price {
font-weight:600;
}

#total_price:after {
content:' руб.';
display:inline-block;
margin-left:6px;
}

.button_order {
display:block;
background-color:#ac1068;
color:#fff!important;
text-decoration:none!important;
font-size:13px;
line-height:34px;
height:34px;
text-align:center;
margin:20px 24px 30px;
}

.button_order:hover {
opacity:.7;
color:#fff;
text-decoration:none;
}

.cart_item_delete {
font-size:20px;
color:#858586;
cursor:pointer;
position:absolute;
display:block;
top:10px;
right:0;
width:18px;
height:18px;
}

#cart_message {
position:relative;
text-align:left;
border-bottom:1px solid #3f3f3f;
width:auto;
margin-left:24px;
margin-right:24px;
padding:6px 0;
}

#cart_message span {
color:#fff!important;
line-height:20px;
display:inline-block;
font-size:16px;
opacity:1!important;
text-decoration:none!important;
}

.modal_item_header {
margin-top:30px!important;
font-size:20px;
display:block;
}

.modal_item_header,.modal_item_desc {
font-weight:600;
margin:12px 28px;
}

.modal_item_name {
font-size:14px;
font-weight:600;
}

.modal_item_header,.modal_item_name {
color:#141516;
}

.modal_item_img {
max-height:160px;
height:100%;
max-width:100%;
display:block;
margin:0 auto 20px;
}

#modalOrderHeader {
border-bottom:none;
padding:0;
}

#search button {
display:block;
float:right;
font-size:18px;
line-height:55px;
color:#fff!important;
position:relative;
z-index:99;
}

.top_panel_element,.top_panel button {
width:62px;
}

.top_panel_element,.top_panel input,.top_panel button {
line-height:40px;
height:40px;
}

.top_panel button,.top_panel input {
background:none;
border:none;
}

.top_panel button {
text-align:center;
}

.top_panel_element {
display:inline-block;
vertical-align:top;
position:relative;
}

#auth_top_form .input_auth_top {
display:block;
color:#858586;
background-color:#3f3f3f;
width:100%;
font-size:13px;
margin-bottom:12px;
line-height:36px;
height:36px;
padding:0 12px;
}

#cart {
float:left;
position:relative;
}

#cart_items {
background-color:#29292a;
position:absolute;
z-index:999999;
max-height:calc(100vh-56px);
top:56px;
left:inherit;
right:0;
width:290px;
overflow:hidden;
}

.cart_element {
width:100%;
padding:30px 25px;
}

#items .item {
position:relative;
text-align:left;
border-bottom:1px solid #3f3f3f;
width:auto;
margin-left:24px;
margin-right:24px;
padding:15px 0 14px;
}

#items .item img {
max-height:62px;
display:inline-block;
}

#items .item_change_quant.quant_remove_to {
margin-right:5px!important;
}

#items .item_change_quant {
font-size:17px;
}

#search {
margin-right:0;
max-width:236px;
width:150px;
position:relative;
}

#search input,#search input:focus {
position:absolute;
top:0;
right:0;
width:100%;
color:#fff;
padding:0 50px 0 20px;
}

#search input:focus {
width:336px;
position:absolute;
top:0;
right:0;
background:#29292a;
z-index:9;
}

#search input {
position:absolute;
top:0;
right:0;
width:140px;
color:#fff;
padding:0 50px 0 20px;
}

.top_navigation .main_menu > li > a.collapsed.list_catalog,#cart > button.collapsed.transition_02 {
background-color:transparent;
}

#auth_top_form input::-webkit-input-placeholder,#auth_top_form input::-moz-placeholder,#auth_top_form input:-ms-input-placeholder,#auth_top_form input:-moz-placeholder {
color:#858586;
}

#search input::-webkit-input-placeholder,#search input::-moz-placeholder,#search input:-ms-input-placeholder,#search input:-moz-placeholder {
color:#fff;
}

#cart > button.transition_02:hover,#cart > button.transition_02:focus,.top_panel button:hover {
background-color:#29292a;
}

#cart > button.transition_02,#auth_top {
position:relative;
}

#items .item_href:hover,.cart_item_delete:hover img {
opacity:.7;
}

#items .item_change_quant:hover,.cart_item_delete:hover {
color:#f0de86;
}

#cart_items.visible_hidden #cart_message,#cart_items .total_cost,#cart_items #items,#cart_items .button_order,#callbackOrder .close {
display:none!important;
}

#cart_items.visible_hidden .total_cost,#cart_items.visible_hidden #items,#cart_items.visible_hidden .button_order,#cart_items #cart_message {
display:block!important;
}

@media min-width 300px {
.row-flex {
display:block;
flex-flow:nowrap;
}

#top_bar {
top:0;
left:0;
width:100%;
background-color:#1c1c1c;
}

.main_menu.collapse {
display:none;
}

.main_menu.collapse.in {
display:block;
}

.top_navigation nav {
overflow-y:auto;
max-height:100vh;
margin-left:0;
float:none;
}

.top_navigation nav ul {
text-align:left;
list-style-type:none;
margin:0;
padding:0;
}

.top_navigation .main_menu li {
display:list-item;
}

.top_navigation .main_menu li a {
font-size:13px;
display:block;
padding:19px 15px;
}

#collapseMenu_1 {
position:relative;
}

.ver_2_sub_menu {
-moz-column-count:1;
-webkit-column-count:1;
column-count:1;
column-fill:auto;
}

#collapseMenu_1 ul {
background-color:rgba(236,217,126,0.1);
padding-top:20px;
padding-bottom:20px;
}

#collapseMenu_1 li {
margin-bottom:25px;
}

#collapseMenu_1 a {
line-height:30px;
color:#eedb82;
padding:0 5px 0 15px;
}

#menu_img_cat {
max-height:287px;
padding-top:30px;
max-width:100%;
}

.general_cat {
margin-bottom:14px;
}

#collapseMenu_1 a:hover {
opacity:0.7;
text-indent:5px;
padding-right:0;
}

.general_navigation {
padding-top:0;
padding-bottom:0;
}
}

@media min-width 768px {
.top_navigation nav {
margin-left:60px;
overflow-y:hidden;
height:auto;
float:left;
}

.main_menu.collapse {
display:block;
}

.top_navigation nav ul {
background-color:transparent;
}

#collapseMenu_1 {
position:absolute;
background-color:#eedb82;
}

.ver_2_sub_menu {
-moz-column-count:3;
-webkit-column-count:3;
column-count:3;
column-fill:auto;
}

#collapseMenu_1 ul {
padding-top:55px;
padding-bottom:55px;
}

#collapseMenu_1 li {
margin-bottom:40px;
}

#collapseMenu_1 a {
color:#1a1b1b;
line-height:22px;
padding:0 5px 0 0;
}

.general_navigation {
padding-top:2px;
padding-bottom:2px;
}

.top_navigation .main_menu li,.top_navigation .main_menu li a {
display:inline-block;
}
}
</style>
</body>
</html>
<?php $this->endBody() ?>
<?php $this->endPage() ?>
