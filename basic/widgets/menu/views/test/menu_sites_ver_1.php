<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 06.03.2017
 * Time: 6:15
 */
use yii\helpers\Html;
?>
<?php //First
function treeMainItems($cat, $max_level) {
    $max_level--;
    $data = "";
    if($max_level > 0) {
        if($max_level == 1) $data .= "<ul class='multi-column_drop collapse'>";
        else $data .= "<ul>";
        foreach($cat as $c){
            $data .= "<li >";
            if(!$c->isLeaf()) $data .= '<span class="multi-column__title drop_head_multi_column"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> '.$c->name.'</span>'; //загаловок категории
            else {
                if($max_level == 1) $data .= Html::a($c->name,'/category/'.($c->seoTags->slug == null ? $c->id : $c->seoTags->slug), ['class' => 'drop_before']);
                else $data .= Html::a($c->name,'/category/'.($c->seoTags->slug == null ? $c->id : $c->seoTags->slug), ['class' => 'drop_before multi-column__title']);
            }
            if(!$c->isLeaf()) {
                $data .= treeMainItems($c['children'], $max_level );
            }
            /**/
            $data .= "</li>";
        }
        $data .= "</ul>";
    }
    return $data;
}

$activeLink = isset(Yii::$app->params['breadcrumbs'][1]['url'][0]) ? Yii::$app->params['breadcrumbs'][1]['url'][0] : '';

if(empty($activeLink)) $activeLink = "/category/".Yii::$app->request->get("slug");

$max_level = 3;


//* Cache items *
$items = Yii::$app->cache->get('items');
if ($items === false) {
    $items = '<ul id="collapseMenu_1" class="multi-column multi-column_my collapse">';
    foreach($tree as $cat)
    {
        $items .= "<li>";
        if(!$cat->isLeaf()) $items .= Html::tag('span', $cat->name, ['class' => 'multi-column__title head_multi_column']); //загаловок категории
        else $items .= Html::a($cat->name,'/category/'.($cat->seoTags->slug == null ? $cat->id : $cat->seoTags->slug), ['class' => 'drop_before multi-column__title head_multi_column']); //ссыЛка не категории
        if($max_level > 0 && !$cat->isLeaf()) {
            $items .= treeMainItems($cat['children'], $max_level);
        }

        $items .= "</li>";
    }
    $items .= "</ul>";
    Yii::$app->cache->set('items', $items, 1000);
}
//var_dump($tree);
//exit();
// end cache items */
/* NOCache items *
$items = '<ul id="collapseMenu_1" class="multi-column multi-column_my collapse">';

foreach($tree as $cat)
{
    $items .= "<li>";
    if(!$cat->isLeaf()) $items .= Html::tag('span', $cat->name, ['class' => 'multi-column__title head_multi_column']); //загаловок категории
    else $items .= Html::a($cat->name,'/category/'.($cat->seoTags->slug == null ? $cat->id : $cat->seoTags->slug), ['class' => 'multi-column__title head_multi_column']); //ссыЛка не категории
    if($max_level > 0 && !$cat->isLeaf()) {
        $items .= treeMainItems($cat['children'], $max_level);
    }

    $items .= "</li>";
}
$items .= "</ul>";
/**/
?>
<nav class="transition--fade"> <!--nav--open и добавить высоту, дополнительные открываются при помощи active-->
    <div class="nav-bar nav--absolute mobile_menu_active11 nav--transparent" data-fixed-at="200"> <!--nav--fixed class дополнительный-->
        <div class="nav-module logo-module left">
            <a href="index.html">
                <img class="logo logo-dark" alt="logo" src="/img/tmp/logo-dark.png" />
                <img class="logo logo-light" alt="logo" src="/img/tmp/logo-light.png" />
            </a>
        </div>
        <div class="nav-module menu-module left ">
            <span id="menu_close" class="close_default"></span>
            <ul class="menu">
                <li>
                    <a href="/">
                        Главная
                    </a>
                </li>
                <li>
                    <a data-toggle="collapse" data-parent="#top_menu" href="#collapseMenu_1">
                        Категории товаров старый
                    </a>
                    <!-- html -- >
                    <ul id="collapseMenu_1" class="multi-column multi-column_my collapse " aria-expanded="true" style="width: 100%;">
                        <!--верхняя часть меню начало- ->
                        <li style="width:100%;max-width: 100%;float:none;color: #fff;">
                            <ul style="width:100%;max-width: 100%;float:none;">
                                <li style="width:100%;max-width: 100%;float:none;color: #fff;padding-bottom: 1.3em;display: block;text-transform: uppercase;letter-spacing: 1px;padding: 10px 10px 7px;border-bottom: 1px solid #fff;font-weight: 500;font-size: 14px;"><span>Категории товаров</span></li>
                                <li class="clearfix" style="float:none; margin:0; padding:0; height:0; line-height:0; clear: both;"></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0; display: inline-block">одиночная Категория</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0; display: inline-block">одиночная Категория</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0; display: inline-block">одиночная Категория</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0; display: inline-block">одиночная Категория</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0; display: inline-block">одиночная Категория</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0; display: inline-block">одиночная Категория</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0; display: inline-block">одиночная Категория</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0; display: inline-block">одиночная Категория</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0; display: inline-block">одиночная Категория</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0; display: inline-block">одиночная Категория</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0; display: inline-block">одиночная Категория</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0; display: inline-block">одиночная Категория</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0;">в которой нет</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0;">дополнительных категорий или еще чего либо</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0;">Наручные часы 2</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0;">Наручные часы 3 </a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0;">Наручные часы 4</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0;">Наручные часы 5</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0;">Наручные часы 6</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0;">Наручные часы 7</a></li>
                                <li style="padding: 8px 15px 8px; display: inline-block; float:none"><a class="drop_before multi-column__title" href="/category/naruchnye-chasy" style="padding: 0; margin: 0;">Наручные часы 8</a></li>
                                <li class="clearfix" style="float:none; margin:0; padding:0; height:0; line-height:0; clear: both;"></li>
                            </ul>
                        </li>
                        <li class="clearfix" style="float:none; margin:0; padding:0; height:0; line-height:0; clear: both;"></li>
                        <li style="width:100%;max-width: 100%;float:none;color: #fff;">
                            <ul style="width:100%;max-width: 100%;float:none;">
                                <li style="width:100%;max-width: 100%;float:none;color: #fff;padding-bottom: 1.3em;display: block;text-transform: uppercase;letter-spacing: 1px;padding: 10px 10px 7px;border-bottom: 1px solid #fff;font-weight: 500;font-size: 14px;"><span>Коллекция товаров</span></li>
                                <li class="clearfix" style="float:none; margin:0; padding:0; height:0; line-height:0; clear: both;"></li>
                            </ul>
                        </li>
                        <li class="clearfix" style="float:none; margin:0; padding:0; height:0; line-height:0; clear: both;"></li>
                        <!--верхняя часть меню конец -- >
                <li><span class="multi-column__title head_multi_column ver_1_main_link_drop">Изделия из кожи</span><ul class="ver_1_multi-column_drop collapse">
                        <li><a class="drop_before multi-column__title" href="/category/izdeliya-iz-kozhi/ancora/">Все товары категории</a></li>
                        <li><span class="multi-column__title drop_head_multi_column"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> ANCORA (АНКОРА)</span><ul class="multi-column_drop collapse"><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/ancora/chehly-dlya-ruchek">ЧЕХЛЫ ДЛЯ РУЧЕК</a></li></ul></li><li><span class="multi-column__title drop_head_multi_column"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> AURORA (АВРОРА)</span><ul class="multi-column_drop collapse"><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/aurora/portmone">ПОРТМОНЕ</a></li><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/aurora/vizitnicy">ВИЗИТНИЦЫ</a></li><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/aurora/portfeli">ПОРТФЕЛИ</a></li><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/aurora/sumki">СУМКИ</a></li><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/aurora/papki">ПАПКИ</a></li><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/aurora/klyuchnica-brelok-dlya-klyuchey">КЛЮЧНИЦА\БРЕЛОК ДЛЯ КЛЮЧЕЙ</a></li><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/aurora/chehly-dlya-ruchek">ЧЕХЛЫ ДЛЯ РУЧЕК</a></li><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/aurora/ezhednevnik-vstavki-futlyar">ЕЖЕДНЕВНИК\ВСТАВКИ\ФУТЛЯР</a></li><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/aurora/zapisnye-knizhki-bloknoty">ЗАПИСНЫЕ КНИЖКИ\БЛОКНОТЫ</a></li><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/aurora/podstavka-dlya-pisem">ПОДСТАВКА ДЛЯ ПИСЕМ</a></li><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/aurora/lotok-dlya-bumag">ЛОТОК ДЛЯ БУМАГ</a></li></ul></li><li><span class="multi-column__title drop_head_multi_column"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> AVANZO DAZIARO (АВАНЦО ДАЦИАРО)</span><ul class="multi-column_drop collapse"><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/aurora/">ПОРТМОНЕ</a></li><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/avanzo-daziaro/multiportmone">МУЛЬТИПОРТМОНЕ</a></li><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/avanzo-daziaro/vizitnicy">ВИЗИТНИЦЫ</a></li><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/avanzo-daziaro/portfeli">ПОРТФЕЛИ</a></li><li><a class="drop_before" href="/category/izdeliya-iz-kozhi/avanzo-daziaro/papki">ПАПКИ</a></li></ul></li><li><a class="drop_before multi-column__title" href="/category/izdeliya-iz-kozhi/ancora/">CARAN D’ACHE (КАРАНДАШ)</a></li><li><a class="drop_before multi-column__title" href="/category/izdeliya-iz-kozhi/ancora/">CROSS (КРОСС)</a></li><li><a class="drop_before multi-column__title" href="/category/izdeliya-iz-kozhi/ancora/">DALVEY (ДАЛВЕЙ)</a></li><li><a class="drop_before multi-column__title" href="/category/izdeliya-iz-kozhi/ancora/">DUNHILL (ДАНХИЛЛ)</a></li><li><a class="drop_before multi-column__title" href="/category/izdeliya-iz-kozhi/ancora/">EL CASCO (ЭЛЬ КАСКО)</a></li></ul>
                </li>

                <li>
                    <span class="multi-column__title head_multi_column">Аксессуары</span><ul><li><span class="multi-column__title drop_head_multi_column"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> ПОРТМОНЕ</span><ul class="multi-column_drop collapse">
                                <li><a class="drop_before" href="/category/171">ANCORA (АНКОРА)</a></li><li><a class="drop_before" href="/category/175">AURORA (АВРОРА)</a></li><li><a class="drop_before" href="/category/174">AVANZO DAZIARO (АВАНЦО ДАЦИАРО)</a></li><li><a class="drop_before" href="/category/173">CARAN D’ACHE (КАРАНДАШ)</a></li><li><a class="drop_before" href="/category/172">CROSS (КРОСС)</a></li><li><a class="drop_before" href="/category/176">DALVEY (ДАЛВЕЙ)</a></li><li><a class="drop_before" href="/category/177">DUNHILL (ДАНХИЛЛ)</a></li><li><a class="drop_before" href="/category/178">EL CASCO (ЭЛЬ КАСКО)</a></li><li><a class="drop_before" href="/category/171">ANCORA (АНКОРА)</a></li><li><a class="drop_before" href="/category/175">AURORA (АВРОРА)</a></li><li><a class="drop_before" href="/category/174">AVANZO DAZIARO (АВАНЦО ДАЦИАРО)</a></li><li><a class="drop_before" href="/category/173">CARAN D’ACHE (КАРАНДАШ)</a></li><li><a class="drop_before" href="/category/172">CROSS (КРОСС)</a></li><li><a class="drop_before" href="/category/176">DALVEY (ДАЛВЕЙ)</a></li><li><a class="drop_before" href="/category/177">DUNHILL (ДАНХИЛЛ)</a></li><li><a class="drop_before" href="/category/178">EL CASCO (ЭЛЬ КАСКО)</a></li><li><a class="drop_before" href="/category/171">ANCORA (АНКОРА)</a></li><li><a class="drop_before" href="/category/175">AURORA (АВРОРА)</a></li><li><a class="drop_before" href="/category/174">AVANZO DAZIARO (АВАНЦО ДАЦИАРО)</a></li><li><a class="drop_before" href="/category/173">CARAN D’ACHE (КАРАНДАШ)</a></li><li><a class="drop_before" href="/category/172">CROSS (КРОСС)</a></li><li><a class="drop_before" href="/category/176">DALVEY (ДАЛВЕЙ)</a></li><li><a class="drop_before" href="/category/177">DUNHILL (ДАНХИЛЛ)</a></li><li><a class="drop_before" href="/category/178">EL CASCO (ЭЛЬ КАСКО)</a></li></ul></li><li><span class="multi-column__title drop_head_multi_column"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> ВИЗИТНИЦЫ</span><ul class="multi-column_drop collapse"><li><a class="drop_before" href="/category/179">ANCORA (АНКОРА)</a></li><li><a class="drop_before" href="/category/183">AURORA (АВРОРА)</a></li><li><a class="drop_before" href="/category/182">AVANZO DAZIARO (АВАНЦО ДАЦИАРО)</a></li><li><a class="drop_before" href="/category/181">CARAN D’ACHE (КАРАНДАШ)</a></li><li><a class="drop_before" href="/category/180">CROSS (КРОСС)</a></li><li><a class="drop_before" href="/category/184">DALVEY (ДАЛВЕЙ)</a></li><li><a class="drop_before" href="/category/185">DUNHILL (ДАНХИЛЛ)</a></li><li><a class="drop_before" href="/category/186">EL CASCO (ЭЛЬ КАСКО)</a></li></ul></li><li><span class="multi-column__title drop_head_multi_column"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> ПОРТФЕЛИ</span><ul class="multi-column_drop collapse"><li><a class="drop_before" href="/category/163">ANCORA (АНКОРА)</a></li><li><a class="drop_before" href="/category/167">AURORA (АВРОРА)</a></li><li><a class="drop_before" href="/category/166">AVANZO DAZIARO (АВАНЦО ДАЦИАРО)</a></li><li><a class="drop_before" href="/category/165">CARAN D’ACHE (КАРАНДАШ)</a></li><li><a class="drop_before" href="/category/164">CROSS (КРОСС)</a></li><li><a class="drop_before" href="/category/168">DALVEY (ДАЛВЕЙ)</a></li><li><a class="drop_before" href="/category/169">DUNHILL (ДАНХИЛЛ)</a></li><li><a class="drop_before" href="/category/170">EL CASCO (ЭЛЬ КАСКО)</a></li></ul></li><li><span class="multi-column__title drop_head_multi_column"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> СУМКИ</span><ul class="multi-column_drop collapse"><li><a class="drop_before" href="/category/155">ANCORA (АНКОРА)</a></li><li><a class="drop_before" href="/category/159">AURORA (АВРОРА)</a></li><li><a class="drop_before" href="/category/158">AVANZO DAZIARO (АВАНЦО ДАЦИАРО)</a></li><li><a class="drop_before" href="/category/157">CARAN D’ACHE (КАРАНДАШ)</a></li><li><a class="drop_before" href="/category/156">CROSS (КРОСС)</a></li><li><a class="drop_before" href="/category/160">DALVEY (ДАЛВЕЙ)</a></li><li><a class="drop_before" href="/category/161">DUNHILL (ДАНХИЛЛ)</a></li><li><a class="drop_before" href="/category/162">EL CASCO (ЭЛЬ КАСКО)</a></li></ul></li><li><span class="multi-column__title drop_head_multi_column"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> ПАПКИ</span><ul class="multi-column_drop collapse"><li><a class="drop_before" href="/category/147">ANCORA (АНКОРА)</a></li><li><a class="drop_before" href="/category/151">AURORA (АВРОРА)</a></li><li><a class="drop_before" href="/category/150">AVANZO DAZIARO (АВАНЦО ДАЦИАРО)</a></li><li><a class="drop_before" href="/category/149">CARAN D’ACHE (КАРАНДАШ)</a></li><li><a class="drop_before" href="/category/148">CROSS (КРОСС)</a></li><li><a class="drop_before" href="/category/152">DALVEY (ДАЛВЕЙ)</a></li><li><a class="drop_before" href="/category/153">DUNHILL (ДАНХИЛЛ)</a></li><li><a class="drop_before" href="/category/154">EL CASCO (ЭЛЬ КАСКО)</a></li></ul></li><li><span class="multi-column__title drop_head_multi_column"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> КЛЮЧНИЦА\БРЕЛОК ДЛЯ КЛЮЧЕЙ</span><ul class="multi-column_drop collapse"><li><a class="drop_before" href="/category/139">ANCORA (АНКОРА)</a></li><li><a class="drop_before" href="/category/143">AURORA (АВРОРА)</a></li><li><a class="drop_before" href="/category/142">AVANZO DAZIARO (АВАНЦО ДАЦИАРО)</a></li><li><a class="drop_before" href="/category/141">CARAN D’ACHE (КАРАНДАШ)</a></li><li><a class="drop_before" href="/category/140">CROSS (КРОСС)</a></li><li><a class="drop_before" href="/category/144">DALVEY (ДАЛВЕЙ)</a></li><li><a class="drop_before" href="/category/145">DUNHILL (ДАНХИЛЛ)</a></li><li><a class="drop_before" href="/category/146">EL CASCO (ЭЛЬ КАСКО)</a></li></ul></li><li><span class="multi-column__title drop_head_multi_column"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> ЧЕХЛЫ ДЛЯ РУЧЕК</span><ul class="multi-column_drop collapse"><li><a class="drop_before" href="/category/131">ANCORA (АНКОРА)</a></li><li><a class="drop_before" href="/category/135">AURORA (АВРОРА)</a></li><li><a class="drop_before" href="/category/134">AVANZO DAZIARO (АВАНЦО ДАЦИАРО)</a></li><li><a class="drop_before" href="/category/133">CARAN D’ACHE (КАРАНДАШ)</a></li><li><a class="drop_before" href="/category/132">CROSS (КРОСС)</a></li><li><a class="drop_before" href="/category/136">DALVEY (ДАЛВЕЙ)</a></li><li><a class="drop_before" href="/category/137">DUNHILL (ДАНХИЛЛ)</a></li><li><a class="drop_before" href="/category/138">EL CASCO (ЭЛЬ КАСКО)</a></li></ul></li><li><span class="multi-column__title drop_head_multi_column"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> ЕЖЕДНЕВНИК\ВСТАВКИ\ФУТЛЯР</span><ul class="multi-column_drop collapse"><li><a class="drop_before" href="/category/123">ANCORA (АНКОРА)</a></li><li><a class="drop_before" href="/category/127">AURORA (АВРОРА)</a></li><li><a class="drop_before" href="/category/126">AVANZO DAZIARO (АВАНЦО ДАЦИАРО)</a></li><li><a class="drop_before" href="/category/125">CARAN D’ACHE (КАРАНДАШ)</a></li><li><a class="drop_before" href="/category/124">CROSS (КРОСС)</a></li><li><a class="drop_before" href="/category/128">DALVEY (ДАЛВЕЙ)</a></li><li><a class="drop_before" href="/category/129">DUNHILL (ДАНХИЛЛ)</a></li><li><a class="drop_before" href="/category/130">EL CASCO (ЭЛЬ КАСКО)</a></li></ul></li><li><span class="multi-column__title drop_head_multi_column"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> ЗАПИСНЫЕ КНИЖКИ\БЛОКНОТЫ</span><ul class="multi-column_drop collapse"><li><a class="drop_before" href="/category/115">ANCORA (АНКОРА)</a></li><li><a class="drop_before" href="/category/119">AURORA (АВРОРА)</a></li><li><a class="drop_before" href="/category/118">AVANZO DAZIARO (АВАНЦО ДАЦИАРО)</a></li><li><a class="drop_before" href="/category/117">CARAN D’ACHE (КАРАНДАШ)</a></li><li><a class="drop_before" href="/category/116">CROSS (КРОСС)</a></li><li><a class="drop_before" href="/category/120">DALVEY (ДАЛВЕЙ)</a></li><li><a class="drop_before" href="/category/121">DUNHILL (ДАНХИЛЛ)</a></li><li><a class="drop_before" href="/category/122">EL CASCO (ЭЛЬ КАСКО)</a></li></ul></li><li><span class="multi-column__title drop_head_multi_column"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> ПОДСТАВКА ДЛЯ ПИСЕМ</span><ul class="multi-column_drop collapse"><li><a class="drop_before" href="/category/107">ANCORA (АНКОРА)</a></li><li><a class="drop_before" href="/category/111">AURORA (АВРОРА)</a></li><li><a class="drop_before" href="/category/110">AVANZO DAZIARO (АВАНЦО ДАЦИАРО)</a></li><li><a class="drop_before" href="/category/109">CARAN D’ACHE (КАРАНДАШ)</a></li><li><a class="drop_before" href="/category/108">CROSS (КРОСС)</a></li><li><a class="drop_before" href="/category/112">DALVEY (ДАЛВЕЙ)</a></li><li><a class="drop_before" href="/category/113">DUNHILL (ДАНХИЛЛ)</a></li><li><a class="drop_before" href="/category/114">EL CASCO (ЭЛЬ КАСКО)</a></li></ul></li><li><span class="multi-column__title drop_head_multi_column"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> ЛОТОК ДЛЯ БУМАГ</span><ul class="multi-column_drop collapse"><li><a class="drop_before" href="/category/99">ANCORA (АНКОРА)</a></li><li><a class="drop_before" href="/category/103">AURORA (АВРОРА)</a></li><li><a class="drop_before" href="/category/102">AVANZO DAZIARO (АВАНЦО ДАЦИАРО)</a></li><li><a class="drop_before" href="/category/101">CARAN D’ACHE (КАРАНДАШ)</a></li><li><a class="drop_before" href="/category/100">CROSS (КРОСС)</a></li><li><a class="drop_before" href="/category/104">DALVEY (ДАЛВЕЙ)</a></li><li><a class="drop_before" href="/category/105">DUNHILL (ДАНХИЛЛ)</a></li><li><a class="drop_before" href="/category/106">EL CASCO (ЭЛЬ КАСКО)</a></li></ul></li></ul>
                </li>

            </ul>
            <!-- end html -->
                    <?=$items?>
                </li>
                <li>
                    <a href="/site/about">
                        О нас
                    </a>
                </li>
                <li>
                    <a href="/site/contacts">
                        Контакты
                    </a>
                </li>
            </ul>
        </div>
        <!--end nav module-->
        <div class="right utils_bar">
            <div class="nav-module right">
                <a href="#" class="nav-function" data-notification-link="cart-overview">
                    <i class="interface-bag icon icon--sm"></i>
                    <span>Корзина</span>
                </a>
            </div>
            <div class="nav-module right">
                <!--a href="#" class="nav-function modal-trigger" data-modal-id="search-form">
                    <i class="interface-search icon icon--sm"></i>
                    <span>Поиск</span>
                </a-->
            </div>
        </div>
    </div>
    <!--end nav bar-->
    <div class="nav-mobile-toggle visible-sm visible-xs">
        <i class="icon-Align-Right icon icon--sm img-circle"></i>
    </div>
</nav>