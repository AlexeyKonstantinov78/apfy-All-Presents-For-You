<?xml version="1.0"?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
    <channel>
        <title>apfyAllItems</title>
        <link>https://apfy.ru/</link>
        <description>APFY - Все Подарки Для Вас!</description>
        <?php foreach ($products_yml as $k => $v):?><item>
            <g:id><?=$v['id']?></g:id>
            <g:title><?=$v['brand']?> - <?=$v['artid']?>.</g:title>
            <g:description><?=str_replace("&", "&amp;", $v['name'])?>. При заказе товара на сумму от 5000 руб. мы дарим подарок! Официальный дилер бренда <?=$v['brand']?>. Товар раздела сайта - <?=$v['category']?>.</g:description>
            <g:link>https://apfy.ru/product/<?=$v['slug']?></g:link>
            <g:image_link>https://apfy.ru<?=$v['img']?></g:image_link>
            <g:availability>in stock</g:availability>
            <?php if(empty($v['discount_price'])): ?><g:price><?=$v['price']?>.00 RUB</g:price><?php else: ?><g:price><?=$v['discount_price']?>.00 RUB</g:price><g:sale_price><?=$v['price']?>.00 RUB</g:sale_price><?php endif; ?>
            <?php if((float)$v['price'] < 4000): ?>
                <g:shipping>
                    <g:country>RU</g:country>
                    <g:region>Московская область</g:region>
                    <g:service>СДЭК по Москве</g:service>
                    <g:price>125.00 RUB</g:price>
                </g:shipping><?php else: ?>
                <g:shipping>
                    <g:country>RU</g:country>
                    <g:region>Московская область</g:region>
                    <g:service>СДЭК по Москве</g:service>
                    <g:price>0 RUB</g:price>
                </g:shipping><?php endif; ?>

            <!-- 2 of the following 3 attributes are required fot this item according to the Unique Product Identifier Rules -->
            <g:gtin><?=$v['gtin']?></g:gtin>
            <g:brand><?=$v['brand']?></g:brand>
            </item><?php endforeach; ?>
    </channel>
</rss>