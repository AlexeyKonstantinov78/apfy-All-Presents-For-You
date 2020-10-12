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
        <categories>
            <?php foreach ($treeCat as $k=>$v): ?>
                <category id="<?=$k?>" <?php if($v['parent_id'] !== null) echo 'parentId="'.$v['parent_id'].'"'; ?>><?=$v['name']?></category>
            <?php endforeach; ?>
        </categories>
        <delivery-options>
            <option cost="125" days="1" order-before="12"/>
        </delivery-options>
        <offers>
            <?php foreach ($products_yml as $k => $v):?>
                <?php
                $isAr = [
                    475,
                    476
                ];
                if(in_array($v['id'], $isAr)) Continue;
                ?>
                <offer id="<?=$v['id']?>" available="true" bid="25" fee="500">
                    <url>https://apfy.ru/product/<?=$v['slug']?></url>
                    <?php if($v['discount_price']<1): ?>
                        <price><?=$v['price']?></price>
                    <?php else: ?>
                        <oldprice><?=$v['price']?></oldprice>
                        <price><?=$v['discount_price']?></price>
                    <?php endif; ?>
                    <currencyId>RUR</currencyId>
                    <categoryId><?=$v['category']?></categoryId>
                    <picture>https://apfy.ru<?=$v['img']?></picture>
                    <delivery>true</delivery>
                    <name><?=$treeCat[$v['category']]['name']?>. Артикул — <?=$v['artid']?></name>
                    <description>
                        <![CDATA[
                        <?=$v['description']?>
                        ]]>
                    </description><?php // <typePrefix>Канистра для бензина</typePrefix> Указывая тип товара в typePrefix: руководствуйтесь тем, как этот товар позиционирует производитель; не используйте двусмысленные или слишком общие слова. Позднее как нить.?>
                    <vendor><?=$v['brand']?></vendor>
                    <vendorCode><?=$v['artid']?></vendorCode>
                    <delivery-options>
                        <option cost="<?=$v['price'] < 4000 ? '125' : '0'?>" days="1" order-before="12"/>
                    </delivery-options>
                    <barcode><?=str_pad($v['gtin'],  14, "0", STR_PAD_LEFT)?></barcode>
                    <manufacturer_warranty>true</manufacturer_warranty><?php // <cpa>1</cpa> Узнать что такое cpa. ?>
                </offer>
            <?php endforeach; ?>
        </offers>
    </shop>
</yml_catalog>