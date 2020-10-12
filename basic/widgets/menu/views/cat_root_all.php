<?php
//*
use yii\helpers\Html;
$root_cats = Yii::$app->cache->get('root_cats');
//$root_cats = false; //отключить кеш
if ($root_cats === false) {
    foreach($tree as $cat)
    {
        $root_cats .= '<div class="col-md-4 col-xs-6 main_info_wide_grid">';
            $root_cats .= '<a href="/category/'.($cat->seoTags->slug == null ? $cat->id : $cat->seoTags->slug).'">';
                $root_cats .= '<div class="hover-element hover-element-1 row">';
                    $root_cats .= '<div class="hover-element__initial">';
                        $root_cats .= '<img alt="Pic" src="/img/tmp/work6.jpg">';
                        $root_cats .= '<h4 class="unElement">'.$cat->name.'</h4>';
                    $root_cats .= '</div>';
                    $root_cats .= '<div class="hover-element__reveal" data-overlay="9">';
                        $root_cats .= '<div class="boxed">';
                            if (!empty($cat->description)) {
                                $root_cats .= '<span>';
                                    $root_cats .= '<em>Описание:</em>';
                                $root_cats .= '</span>';
                            }
                            $root_cats .= $cat->description;
                        $root_cats .= '</div>';
                    $root_cats .= '</div>';
                $root_cats .= '</div>';
            $root_cats .= '</a>';
        $root_cats .= '</div>';
    }
    Yii::$app->cache->set('root_cats', $root_cats, 10000);
}
?>
<section id="our_brands" class="wide_grid container-fluid padding_104_0_130">
    <h3 class="text-center h_our_brand font_weight_400 font_size_16 font_family_lora">
        <span>Главные категории</span><!--a href="#" class="transition_all">branding</a><a href="#" class="transition_all">digital</a><a href="#" class="transition_all">packaging</a-->
    </h3>

    <div class="row" id="sub_categories">
        <?=$root_cats?>
        <!--div class="col-md-4 col-xs-6 main_info_wide_grid" >
            <a href="#" class="">
                <div class="hover-element hover-element-1 row">
                    <div class="hover-element__initial">
                        <img alt="Pic" src="/img/tmp/work6.jpg">
                        <span class="unElement">iOS Application</span>
                    </div>
                    <div class="hover-element__reveal" data-overlay="9">
                        <div class="boxed">
                            <h5>Freehance</h5>
                            <span>
                                        <em>iOS Application</em>
                                    </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-xs-6">
            <a href="#" >
                <div class="hover-element hover-element-1 row">
                    <div class="hover-element__initial">
                        <img alt="Pic" src="/img/tmp/work2.jpg">
                        <span class="unElement" >Branding &amp; Identity</span>
                    </div>
                    <div class="hover-element__reveal" data-overlay="9">
                        <div class="boxed">
                            <h5>Michael Andrews</h5>
                            <span>
                                    <em></em>
                                </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-xs-6">
            <a href="#">
                <div class="hover-element hover-element-1 row">
                    <div class="hover-element__initial">
                        <img alt="Pic" src="/img/tmp/work7.jpg">
                        <span class="unElement">Branding Collateral</span>
                    </div>
                    <div class="hover-element__reveal" data-overlay="9">
                        <div class="boxed">
                            <h5>Pillar Stationary</h5>
                            <span>
                                    <em>Branding Collateral</em>
                                </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-xs-6">
            <a href="#">
                <div class="hover-element hover-element-1 row" >
                    <div class="hover-element__initial">
                        <img alt="Pic" src="/img/tmp/work5.jpg">
                        <span class="unElement" >Authentic Apparel</span>
                    </div>
                    <div class="hover-element__reveal" data-overlay="9">
                        <div class="boxed">
                            <h5>Authentic Apparel</h5>
                            <span>
                                    <em>Packaging Design</em>
                                </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-xs-6">
            <a href="#">
                <div class="hover-element hover-element-1 row">
                    <div class="hover-element__initial">
                        <img alt="Pic" src="/img/tmp/work10.jpg">
                        <span class="unElement">Wave Poster</span>
                    </div>
                    <div class="hover-element__reveal" data-overlay="9">
                        <div class="boxed">
                            <h5>Wave Poster</h5>
                            <span>
                                    <em>Logo Design</em>
                                </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-xs-6">
            <a href="#">
                <div class="hover-element hover-element-1 row">
                    <div class="hover-element__initial">
                        <img alt="Pic" src="/img/tmp/work12.jpg">
                        <span class="unElement">Apple Watch Application</span>
                    </div>
                    <div class="hover-element__reveal" data-overlay="9">
                        <div class="boxed">
                            <h5>Tesla Controller</h5>
                            <span>
                                    <em>Apple Watch Application</em>
                                </span>
                        </div>
                    </div>
                </div>
            </a>
        </div-->
    </div>
</section>