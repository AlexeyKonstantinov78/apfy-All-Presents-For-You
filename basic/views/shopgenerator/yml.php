<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?><!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="<?=date ("Y-m-d H:m")?>">
    <shop>
        <name>apfy</name>
        <company>ИП Солин М.М.</company>
        <url>https://apfy.ru/</url>
        <currencies>
            <currency id="RUR" rate="1" plus="0"/>
        </currencies>
        <delivery>true</delivery>
        <delivery-options>
            <option cost="0" days="1" order-before="12"/>
        </delivery-options>
        <categories>
            <?php foreach ($treeCat as $k=>$v): ?>
                <category id="<?=$k?>" <?php if($v['parent_id'] !== null) echo 'parentId="'.$v['parent_id'].'"'; ?>><?=$v['name']?></category>
            <?php endforeach; ?>
        </categories>
        <offers>
            <?php foreach ($products_yml as $k => $v):?>
                <?php if($v['category'] == '') Continue; ?>
                <offer id="<?=$v['id']?>" available="true" bid="25" fee="500">
                    <url>https://apfy.ru/product/<?=$v['slug']?></url>
					<?php if(!empty($v['discount_price']) && $v['discount_price']>0): ?>
						<?php $v['price'] = $v['discount_price']; ?>						
                    <?php endif; ?>
                    <price><?=$v['price']?></price>
                    <currencyId>RUR</currencyId>
                    <?php if($v['price']>4000): ?>
                        <delivery-options>
                            <option cost="0" days="1" order-before="12"/>
                        </delivery-options>
                    <?php else: ?>
                        <delivery-options>
                            <option cost="125" days="1" order-before="12"/>
                        </delivery-options>
                    <?php endif; ?>
                    <categoryId><?=$v['category']?></categoryId>
                    <picture>https://apfy.ru<?=$v['img']?></picture>
                    <delivery>true</delivery>
                    <vendor><?=$v['brand']?></vendor>
                    <name><?=str_replace("&", "&amp;", $v['name'])?></name>
                    <vendorCode><?=$v['artid']?></vendorCode>
                    <manufacturer_warranty>true</manufacturer_warranty>
                    <cpa>1</cpa>
                </offer>
            <?php endforeach; ?>
        </offers>
    </shop>
</yml_catalog>