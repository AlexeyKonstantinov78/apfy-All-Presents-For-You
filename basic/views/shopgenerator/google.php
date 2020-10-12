<?xml version="1.0"?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
    <channel>
        <title>apfyAllItems</title>
        <link>https://apfy.ru/</link>
        <description>APFY - Все Подарки Для Вас!</description>
        <?php foreach ($products_yml as $k => $v):?><item>
            <g:id><?=$v['id']?></g:id>
            <g:title><?=$v['brand']?> - <?=$v['artid']?>.</g:title>
            <g:description><?=str_replace("&", "&amp;", $v['name'])?>. APFY.RU дарит подарок при заказе от 5000 руб.! Официальный дилер бренда <?=$v['brand']?>. Товар раздела сайта - <?=$v['category']?>.</g:description>
            <g:link>https://apfy.ru/product/<?=$v['slug']?></g:link>
            <?php if(!empty($v['category'])): ?><g:product_type><?=$v['category']?></g:product_type><?php endif; ?>
            <g:image_link>https://apfy.ru<?=$v['img']?></g:image_link>
            <g:availability>in stock</g:availability>
            <?php if($v['discount_price']<1): ?><g:price><?=$v['price']?>.00 RUB</g:price><?php else: ?><g:price><?=$v['price']?>.00 RUB</g:price><g:sale_price><?=$v['discount_price']?>.00 RUB</g:sale_price><?php endif; ?>
            <?php if((float)$v['price'] < 4000): ?>
            <g:shipping>
                <g:country>RU</g:country>
                <g:service>СДЭК по Москве</g:service>
                <g:price>125.00 RUB</g:price>
            </g:shipping><?php else: ?>
            <g:shipping>
                <g:country>RU</g:country>
                <g:service>СДЭК по Москве</g:service>
                <g:price>0 RUB</g:price>
            </g:shipping><?php endif; ?>

            <!-- 2 of the following 3 attributes are required fot this item according to the Unique Product Identifier Rules -->
            <g:gtin><?=str_pad($v['gtin'],  14, "0", STR_PAD_LEFT)?></g:gtin>
            <g:brand><?=$v['brand']?></g:brand>
            <g:custom_label_0><?=$v['brand']?></g:custom_label_0>
            <?php if((float)$v['price'] > 1000): ?><g:custom_label_1>from_1000</g:custom_label_1><?php else: ?><g:custom_label_1>bofore_1000</g:custom_label_1><?php endif; ?>

        </item><?php endforeach; ?>
    </channel>
</rss>