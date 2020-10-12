<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 04.02.2019
 * Time: 13:14
 */
use app\modules\shop\models\Category;
$filterCache = Yii::$app->cache->get('filter-'.$id);
//$filterCache = Category::generateBadFiltresCats($model);


if (isset($_GET['debFilter'])) {
    $filterCache = false;
}
//$filterCache = false;
if ($filterCache === false) {
    $filterCache = Category::generateBadFiltresCats($model);
    Yii::$app->cache->set('filter-'.$id, $filterCache, 1000000);
}
$this->registerCssFile('/css/site/pagesCss/filter-test.css');
$this->registerCssFile('/js/plugins/ui/jquery-ui.min.css');
$this->registerJsFile('/js/plugins/ui/jquery-ui.min.js', ['depends'=> ['app\assets\AppAsset'],'position' => \yii\web\View::POS_END]);

$jsVar =
    '
    var maxSlide = '. $price['max'].', minSlide = '. $price['min'].';
     '
;
//*/
$js = <<<JS
$(document).ready( function(){
    $('#sliderMaxMin').slider({
        animate: true,
        range: true,
        values: [ minSlide, maxSlide ],
        min: minSlide,
        max: maxSlide,
        step: 50,
        slide: function( value, index ) {
            $('#minPrice').val(index.values[0]);
            $('#maxPrice').val(index.values[1]);
            $('#minPriceSpan').text(index.values[0]);
            $('#maxPriceSpan').text(index.values[1]);
        }
    });
    //скрыть/открыть фильтры
    $('#asideFilters .asideFilter .h4').on('click', function(){
        $(this).parent().toggleClass('active')
    });
    
    $('#applyFilters').on('submit, click', function(){
        $.post( '/shop/elastic/filters_products', $('#asideFilters').serialize(), function( data ) {
            console.log(data);
            $('#category_products').html(data);
			$('.pagination-container.pagination_dis').remove();
        });
        return false;
    });
    $('#resetFilters').on('click', function(){
        $('#asideFilters .asideFilterParametr .checkbox input').prop("checked", false);
        return false;
    });
});
JS;
$this->registerJs($jsVar.$js);
?>
<aside class="col-md-3">
    <h3 class="h4 text-center text-uppercase" style="margin-bottom: 30px">Фильтры товаров:</h3>
    <form id="asideFilters">
        <input type="hidden" name="rootCatId" value="<?=$id?>" />
        <div class="asideFilter active">
            <h4 class="h4 defaultBold text-uppercase">Розничная цена <span class="caret"></span></h4>
            <div class="asideFilterParametr">
                <div class="form-group asideFilterPrice">
                    <input id="minPrice" type="text" value="<?=$price['min']?>" name="minPrice" min="<?=$price['min']?>" max="<?=$price['max']?>" placeholder="0"/>
                    <input id="maxPrice" type="text" value="<?=$price['max']?>" name="maxPrice" class="pull-right" min="<?=$price['min']?>" max="<?=$price['max']?>" placeholder="0"/>
                </div>
                <div class="form-group" style="margin-bottom: 8px">
                    <div id="sliderMaxMin"></div>
                </div>
                <div class="form-group asideFilterPrice ">
                    <span id="minPriceSpan" class="asideFilterPriceMore"><?=$price['min']?></span>
                    <span id="maxPriceSpan" class="pull-right asideFilterPriceMore"><?=$price['max']?></span>
                </div>
            </div>
        </div>
        <?php if(!empty($filterCache)): ?>
            <?php foreach ($filterCache as $k => $v): ?>
                <?php if($k>1000001111): ?>
                    <div class="asideFilter">
                        <h4 class="h4 defaultBold text-uppercase"><?=$v['root']['name']?> <span class="caret"></span></h4>
                        <div class="asideFilterParametr text-uppercase">
                            <?php foreach ($v['root']['children'] as $kChild => $vChild): ?>
                                <div class="checkbox" >
                                    <label>
                                        <input type="checkbox" name="filters[<?=$v['root']['id']?>][]" value="<?=$vChild['id']?>"><?=$vChild['name']?>
                                    </label>
                                    <span class="transition_02 checkboxQuant pull-right"><?=$vChild['count']?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="asideFilter">
                        <h4 class="h4 defaultBold text-uppercase"><?=$v['root']['name']?> <span class="caret"></span></h4>
                        <div class="asideFilterParametr text-uppercase">
                            <?php foreach ($v['root']['children'] as $kChild => $vChild): ?>
                                <div class="checkbox" >
                                    <label>
                                        <input type="checkbox" name="filters[<?=$v['root']['id']?>][]" value="<?=$vChild['id']?>"><?=$vChild['name']?>
                                    </label>
                                    <a href="<?=$vChild['url']?>" title="<?=$vChild['name']?>" class="transition_02 checkboxQuant pull-right"><?=$vChild['count']?></a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <button id="applyFilters" class="transition_02 none_outline default_button text-uppercase red_but_font_filt">Подобрать</button>
        <button id="resetFilters" class="transition_02 none_outline default_button text-uppercase red_but_font_filt">Очистить</button>
    </form>
	<?php if($id === 391): ?>
		<section class="banners-category">
			<a href = "/articles/novosti/s-1-avgusta-2019-g-na-apfyru-provoditsya-akciya-na-ruchki-pierre-cardin-iz-kollekcii-libra-i-slim" title="Акция на ручки Pierre Cardin из коллекция Libra">
				<img src = "/uploads/other_images/350x500_LIBRA.jpg" alt = "Акция на ручки Pierre Cardin из коллекция Libra" />
			</a>
			<a href = "/articles/novosti/s-1-avgusta-2019-g-na-apfyru-provoditsya-akciya-na-ruchki-pierre-cardin-iz-kollekcii-libra-i-slim" title="Акция на ручки Pierre Cardin из коллекция Slim">
				<img src = "/uploads/other_images/350x500_SLIM.jpg" alt = "Акция на ручки Pierre Cardin из коллекция Slim" />
			</a>
		</section>
	<?php endif; ?>
</aside>
