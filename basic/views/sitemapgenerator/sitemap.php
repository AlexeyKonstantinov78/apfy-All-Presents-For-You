<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <?php
    foreach($urls as $url):
        $lastmod = explode(" ",$url->lasted);
        $lastmod = $lastmod[0];
        if($url->object == 'Page' && $url->slug == 'glavnaya') {
    ?>
            <url>
                <loc>https://apfy.ru/</loc>
                <lastmod><?=$lastmod?></lastmod>
            </url>
        <?php continue; } ?>
        <url>
            <?php if($url->slug == 'novosti'): ?>
                <loc>https://apfy.ru/<?=str_replace(["articlecategory", "articles"],["articles","articles"],strtolower($url->object)) ?>/<?=$url->slug?></loc>
            <?php else: ?>
                <loc>https://apfy.ru/<?=str_replace(["articlecategory", "articles"],["articles","articles/novosti"],strtolower($url->object)) ?>/<?=$url->slug?></loc>
            <?php endif; ?>

            <lastmod><?=$lastmod?></lastmod>
        </url>
    <?php endforeach;?>
</urlset>