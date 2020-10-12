<?php echo '<?xml version="1.0"?>'; ?>
<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
    <channel>
        <title>APFY</title>
        <link>https://apfy.ru/</link>
        <description>APFY - все подарки для Вас!</description>
        <?php foreach ($products_yml as $k => $v):?>
            <?php //if($v['category'] == '') Continue; ?>
            <item>
                <g:id><?=$v['id']?></g:id>
                <g:title>Артикул товара - <?=$v['artid']?>. Товар из раздела - <?=$v['category']?>.</g:title>
                <g:link>https://apfy.ru/product/<?=$v['slug']?></g:link>
                <g:availability>in stock</g:availability>
                <?php if(!empty($v['description'])): ?>
                    <g:description><?=$v['description']?></g:description>
                <?php else: ?>
                    <g:description><?=str_replace("&", "&amp;", $v['name'])?></g:description>
                <?php endif; ?>

                <?php //Дополнительная инфа ?>
                <g:image_link>https://apfy.ru<?=$v['img']?></g:image_link>
                <g:brand><?=$v['brand']?></g:brand>
                <g:gtin><?=$v['gtin']?></g:gtin>
                <g:unit_pricing_base_measure>ct</g:unit_pricing_base_measure>
                <g:condition>new</g:condition>

                <?php //Цена ?>
                <?php if(empty($v['discount_price'])): ?>
                    <g:price><?=$v['price']?>.00 RUB</g:price>
                <?php else: ?>
                    <g:price><?=$v['discount_price']?>.00 RUB</g:price>
                    <g:sale_price><?=$v['price']?>.00 RUB</g:sale_price>
                <?php endif; ?>

                <?php //Доставка ?>
                <?php if((float)$v['price'] < 4000): ?>
                    <g:shipping>
                        <g:country>RUS</g:country>
                        <g:region>Московская область</g:region>
                        <g:service>СДЭК по Москве</g:service>
                        <g:price>125 RUB</g:price>
                    </g:shipping>
                <?php else: ?>
                    <g:shipping>
                        <g:country>RUS</g:country>
                        <g:region>Московская область</g:region>
                        <g:service>СДЭК по Москве</g:service>
                        <g:price>0 RUB</g:price>
                    </g:shipping>
                <?php endif; ?>
            </item>
            <?php if($k == 1) Break; ?>
        <?php endforeach; ?>
    </channel>
    <?php
    //<title><?=str_replace("&", "&amp;", $v['name'])? ></title>
    //Атрибут product_type [тип_товара] позволяет по-своему классифицировать товары в фиде.

    ?>
</rss>