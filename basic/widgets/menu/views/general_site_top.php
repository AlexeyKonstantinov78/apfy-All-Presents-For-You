<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 06.03.2017
 * Time: 6:15
 */
/*
 *
 *
 * /
use yii\helpers\Html;
function treeMainItems($cat, $max_level) {
    $max_level--;
    $data = "";
    if($max_level > 0) {
        foreach($cat as $c){
            if($c->active == 0) Continue;
            //$data .= '<span  class="">';
            $data .= Html::a($c->name,'/category/'.($c->seoTags->slug == null ? $c->id : $c->seoTags->slug), ['class' => 'transition_02', 'data-img'=>$c->mainImage->thumb(240)]);
            //$data .= '</span>';
        }
    }
    return $data;
}

$activeLink = isset(Yii::$app->params['breadcrumbs'][1]['url'][0]) ? Yii::$app->params['breadcrumbs'][1]['url'][0] : '';

if(empty($activeLink)) $activeLink = "/category/".Yii::$app->request->get("slug");

$max_level = 2;


/* Cache items * /
$items = Yii::$app->cache->get('items');
$items = false; //отключить кеш
if ($items === false) {
    $items = '<div id="collapseMenu_1" class="collapse other_collapse "><div class="container"><div class="row"><ul class="ver_2_sub_menu col-lg-8 col-md-9 col-xs-12">';
    foreach($tree as $cat)
    {
        if($cat->active == 0) Continue;
        $items .= '<li class=" ">';
        $items .= '<a href="/category/'.($cat->seoTags->slug == null ? $cat->id : $cat->seoTags->slug).'" data-img="'.$cat->mainImage->thumb(240).'" class="transition_02 general_cat text-uppercase"><b>'.$cat->name.'</b></a>';
        //Html::a($cat->name,'/category/'.($cat->seoTags->slug == null ? $cat->id : $cat->seoTags->slug), ['class' => 'main_cat_href transition_leaner_02 ']); //ссылка категории
        if($max_level > 0 && !$cat->isLeaf()) {
            $items .= treeMainItems($cat['children'], $max_level);
        }
        $items .= "</li>";
    }
    $items .= "</ul><div class='col-lg-4 col-md-3 visible-lg visible-md'><img id='menu_img_cat' src='/img/site/test/cat_menu.jpg'></div></div></div></div>";
    Yii::$app->cache->set('items', $items, 10000);
}
/**/
?>
<nav>
    <button type="button" class="navbar-toggle mob_button" data-toggle="collapse" data-parent="#top_bar" data-target="#navbar_main" aria-expanded="false" aria-controls="navbar_main">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <ul class="main_menu collapse" id="navbar_main">
        <li>
            <a href="/" class="transition_02">
                Главная
            </a>
        </li>
        <li>
            <a class="list_catalog transition_02 collapsed all_collapse"
               data-toggle="collapse" data-parent="#top_menu"
               href="#collapseMenu_1" >
                Каталог
            </a>
            <?php //echo $items; ?>
            <div id="collapseMenu_1" class="collapse other_collapse ">
                <div class="container"><div class="row"><ul class="ver_2_sub_menu col-lg-8 col-md-9 col-xs-12"><li class=" "><a href="/category/pishushchie-instrumenty" data-img="/_uploads/Kartinki_dlya_kategorij/Pishuschie_instrumenty/1931598-20659d.jpg" class="transition_02 general_cat text-uppercase"><b>Пишущие инструменты</b></a><a class="transition_02" href="/category/parker" data-img="/_uploads/Kartinki_dlya_kategorij/Pishuschie_instrumenty/Parker/logo-2dcb41.jpg">Parker</a><a class="transition_02" href="/category/pishushchie-instrumenty-waterman" data-img="/_uploads/Kartinki_dlya_kategorij/Pishuschie_instrumenty/Waterman/logo-4c2051.jpg">Waterman</a><a class="transition_02" href="/category/pishushchie-instrumenty-pelikan" data-img="/_uploads/Kartinki_dlya_kategorij/Pishuschie_instrumenty/Pelikan/logo-d42166.jpg">Pelikan</a><a class="transition_02" href="/category/pishushchie-instrumenty-caran-dache" data-img="/_uploads/Kartinki_dlya_kategorij/Pishuschie_instrumenty/Caran_dAche/Logo-f53fab.jpg">Caran dAche</a><a class="transition_02" href="/category/pishushchie-instrumenty-cross" data-img="/_uploads/Kartinki_dlya_kategorij/Pishuschie_instrumenty/Cross/Logo-53c16b.jpg">Cross</a><a class="transition_02" href="/category/pishushchie-instrumenty-pierre-cardin" data-img="/_uploads/Kartinki_dlya_kategorij/Pishuschie_instrumenty/Pierre_Cardin/logo-00d607.jpg">Pierre Cardin</a><a class="transition_02" href="/category/pishushchie-instrumenty-franklin-covey" data-img="/_uploads/Kartinki_dlya_kategorij/Pishuschie_instrumenty/Franklin_Covey/Logo-4247f6.jpg">Franklin Covey</a><a class="transition_02" href="/category/pishushchie-instrumenty-rashodnye-materialy" data-img="/_uploads/Kartinki_dlya_kategorij/Pishuschie_instrumenty/Rashodnye_materialy/1950376-b93b8f.jpg">Расходные материалы</a></li><li class=" "><a href="/category/nozhi-victorinox" data-img="/_uploads/Kartinki_dlya_kategorij/Nozhi_Victorinox/1.3603.T-5dd6cc.jpg" class="transition_02 general_cat text-uppercase"><b>Victorinox</b></a><a class="transition_02" href="/category/nozhi-victorinox-perochinnye-nozhi-victorinox" data-img="/_uploads/Kartinki_dlya_kategorij/Nozhi_Victorinox/Perocinnye/1.6795-2f2c90.jpg">Перочинные ножи Victorinox</a><a class="transition_02" href="/category/nozhi-victorinox-kuhonnye-nozhi-victorinox" data-img="/_uploads/Kartinki_dlya_kategorij/Nozhi_Victorinox/Kuhonnye/6.7127.6L14-1601bb.jpg">Кухонные ножи Victorinox</a><a class="transition_02" href="/category/nozhi-victorinox-aksessuary-victorinox" data-img="/_uploads/Kartinki_dlya_kategorij/Nozhi_Victorinox/Aksessuary/4.0289.1-2ba5cb.jpg">Аксессуары Victorinox</a></li><li class=" "><a href="/category/zazhigalki-i-aksessuary" data-img="/_uploads/Kartinki_dlya_kategorij/Zazhigalki/20854-f1759c.jpg" class="transition_02 general_cat text-uppercase"><b>Зажигалки и аксессуары</b></a><a class="transition_02" href="/category/zazhigalki-i-aksessuary-zippo" data-img="/_uploads/Kartinki_dlya_kategorij/Zazhigalki/Zippo/logo-526f90.jpg">Zippo</a><a class="transition_02" href="/category/zazhigalki-i-aksessuary-pierre-cardin" data-img="/_uploads/Kartinki_dlya_kategorij/Zazhigalki/Pierre_Cardin/logo-2e0a60.jpg">Pierre Cardin</a><a class="transition_02" href="/category/zazhigalki-i-aksessuary-caseti" data-img="/_uploads/Kartinki_dlya_kategorij/Zazhigalki/Caseti/Caseti_logo-f9af99.jpg">Caseti</a><a class="transition_02" href="/category/zazhigalki-i-aksessuary-stinger" data-img="/_uploads/Kartinki_dlya_kategorij/Outdoor/Stinger/logo-5d05b1.jpg">Stinger</a><a class="transition_02" href="/category/zazhigalki-i-aksessuary-squire" data-img="/_uploads/Kartinki_dlya_kategorij/Zazhigalki/SQUIRE/logo-5db681.jpg">S.QUIRE</a><a class="transition_02" href="/category/zazhigalki-i-aksessuary-wenger" data-img="/_uploads/Kartinki_dlya_kategorij/Zazhigalki/Wenger/logo-b03f69.jpg">Wenger</a><a class="transition_02" href="/category/zazhigalki-i-aksessuary-n" data-img="/_uploads/Kartinki_dlya_kategorij/Zazhigalki/Novinki/NOVINKI-e63c06.jpg">Новинки</a></li><li class=" "><a href="/category/ryukzaki-sumki-dorozhnye-aksessuary" data-img="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/3259112410-e55190.jpg" class="transition_02 general_cat text-uppercase"><b>Рюкзаки, сумки, дорожные аксессуары</b></a><a class="transition_02" href="/category/ryukzaki-sumki-dorozhnye-aksessuary-tigernu" data-img="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/Tigernu/tigernu_logo-a3e1ac.jpg">Tigernu</a><a class="transition_02" href="/category/ryukzaki-sumki-dorozhnye-aksessuary-tangcool" data-img="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/TANGCOOL/Logo-aab09e.jpg">TANGCOOL</a><a class="transition_02" href="/category/ryukzaki-sumki-dorozhnye-aksessuary-piquadro" data-img="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/Piquadro/Logo1-2e25e2.jpg">Piquadro</a><a class="transition_02" href="/category/ryukzaki-sumki-dorozhnye-aksessuary-wenger-i-swissgear" data-img="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/Wenger_i_SwissGear/logo-9c86b1.jpg">Wenger</a><a class="transition_02" href="/category/ryukzaki-sumki-dorozhnye-aksessuary-victorinox" data-img="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/Victorinox/logo-4d0ee7.jpg">Victorinox</a><a class="transition_02" href="/category/ryukzaki-sumki-dorozhnye-aksessuary-kozhanaya-kollekciya-cross" data-img="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/Kozhanaya_kollekciya_Cross/Logo-18c1ff.jpg">Cross</a><a class="transition_02" href="/category/ryukzaki-sumki-dorozhnye-aksessuary-klondike-1896" data-img="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/Klondike/logo-757f33.JPG">Klondike 1896</a><a class="transition_02" href="/category/ryukzaki-sumki-dorozhnye-aksessuary-zippo" data-img="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/Zippo/logo-526f90.jpg">Zippo</a><a class="transition_02" href="/category/ryukzaki-sumki-dorozhnye-aksessuary-8848" data-img="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/8848/imgo8848-4cf503.jpg">8848</a><a class="transition_02" href="/category/ryukzaki-sumki-dorozhnye-aksessuary-squire" data-img="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/SQUIRE/logo-5db681.jpg">S.QUIRE</a><a class="transition_02" href="/category/ryukzaki-sumki-dorozhnye-aksessuary-pierre-cardin" data-img="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/Pierre_Cardin/logo-7f9887.jpg">Pierre Cardin</a><a class="transition_02" href="/category/ryukzaki-sumki-dorozhnye-aksessuary-caseti" data-img="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/Caseti/Caseti_logo-431f84.jpg">Caseti</a><a class="transition_02" href="/category/ryukzaki-sumki-dorozhnye-aksessuary-kingsons" data-img="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/Kingsons/kingsons_logo-31fd19.png">Kingsons</a><a class="transition_02" href="/category/ryukzaki-sumki-dorozhnye-aksessuary-mark-ryden" data-img="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/Mark_Ryden/LOGO_MARK_RYDEN-497270.jpg">Mark Ryden</a><a class="transition_02" href="/category/ryukzaki-sumki-dorozhnye-aksessuary-novinki" data-img="/_uploads/Kartinki_dlya_kategorij/NOVINKI-09a96f.jpg">Новинки</a></li><li class=" "><a href="/category/tovary-dlya-aktivnogo-otdyha" data-img="/_uploads/Kartinki_dlya_kategorij/Outdoor/HY-LB407-2-8a39e6.jpg" class="transition_02 general_cat text-uppercase"><b>Товары для активного отдыха</b></a><a class="transition_02" href="/category/tovary-dlya-aktivnogo-otdyha-leatherman" data-img="/_uploads/Kartinki_dlya_kategorij/Outdoor/Leatherman/Logo-199a4c.jpg">Leatherman</a><a class="transition_02" href="/category/tovary-dlya-aktivnogo-otdyha-led-lenser" data-img="/_uploads/Kartinki_dlya_kategorij/Outdoor/Led_Lenser/Logo-cb3788.jpg">Led Lenser</a><a class="transition_02" href="/category/tovary-dlya-aktivnogo-otdyha-thermos" data-img="/_uploads/Kartinki_dlya_kategorij/Outdoor/Thermos/Logo-6b951f.jpg">Thermos</a><a class="transition_02" href="/category/tovary-dlya-aktivnogo-otdyha-stanley" data-img="/_uploads/Kartinki_dlya_kategorij/Outdoor/Stanley/Stanley-2a9c7e.jpg">Stanley</a><a class="transition_02" href="/category/tovary-dlya-aktivnogo-otdyha-morakniv" data-img="/_uploads/Kartinki_dlya_kategorij/Outdoor/Morakniv/morakniv-4ed2a4.jpg">Morakniv</a><a class="transition_02" href="/category/tovary-dlya-aktivnogo-otdyha-squire" data-img="/_uploads/Kartinki_dlya_kategorij/Outdoor/SQUIRE/logo-5db681.jpg">S.QUIRE</a><a class="transition_02" href="/category/outdoor-stinger" data-img="/_uploads/Kartinki_dlya_kategorij/Outdoor/Stinger/logo-5d05b1.jpg">Stinger</a><a class="transition_02" href="/category/tovary-dlya-aktivnogo-otdyha-zippo" data-img="/_uploads/Kartinki_dlya_kategorij/Outdoor/Zippo/logo-526f90.jpg">Zippo</a><a class="transition_02" href="/category/outdoor-novinki" data-img="/_uploads/Kartinki_dlya_kategorij/NOVINKI-09a96f.jpg">Новинки</a></li><li class=" "><a href="/category/novinki" data-img="/_uploads/Kartinki_dlya_kategorij/NOVINKI-09a96f.jpg" class="transition_02 general_cat text-uppercase"><b>Новинки!</b></a></li><li class=" "><a href="/category/rasprodazha" data-img="/_uploads/Kartinki_dlya_kategorij/sale-9cc3fe.jpg" class="transition_02 general_cat text-uppercase"><b>Распродажа!</b></a></li></ul><div class="col-lg-4 col-md-3 visible-lg visible-md"><img id="menu_img_cat" src="/_uploads/Kartinki_dlya_kategorij/Ryukzaki_i_sumki/Caseti/Caseti_logo-431f84.jpg"></div></div></div>
            </div>
        </li>
        <li>
            <a class="transition_02" href="/articles/novosti">
                Новости
            </a>
        </li>
        <li>
            <a class="transition_02" href="/page/delivery">
                Доставка и оплата
            </a>
        </li>
        <li>
            <a class="transition_02" href="/page/garantii-i-vozvrat">
                Гарантии и возврат
            </a>
        </li>
        <li>
            <a class="transition_02" href="/page/about">
                О нас
            </a>
        </li>
        <li>
            <a class="transition_02" href="/page/contacts">
                Контакты
            </a>
        </li>
    </ul>
</nav>