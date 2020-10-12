<?php

echo \moonland\phpexcel\Excel::export([
    'models' => $model,
    'mode' => 'export',
    'format' => 'Excel2007',
    //'columns' => ['id', ['attribute' => 'artid', 'header' => 'artid', 'format'=>'text','value' => function($m){ return "article - ".$m['artid']; } ], 'name', 'price', 'sort', 'active'],
    'columns' => [
        'id',
        ['attribute' => 'artid', 'header' => 'artid', 'format'=>'text','value' => function($m){ return $m->artid." "; } ],
        ['attribute' => 'gtin', 'header' => 'gtin', 'format'=>'text','value' => function($m){ return $m->gtin." "; } ],
        'name',
        ['attribute' => 'slug', 'header' => 'slug', 'format'=>'text','value' => function($m){ return 'https://apfy.ru/product/' .$m->seo->slug; } ],
        ['attribute' => 'mainImage', 'header' => 'mainImage', 'format'=>'text','value' => function($m){ return 'https://apfy.ru' .$m->mainImage->image; } ],
        'price',
        'sort',
        'active',
        'discount_price',
        ['attribute' => 'brands', 'header' => 'brands', 'format'=>'text','value' => function($m){ return $m->getBrandProduct(); } ],
        ['attribute' => 'date', 'header' => 'date', 'format'=>'text','value' => function($m){ return date("d/m/y", strtotime($m->seo->lasted)); } ],
        //['attribute' => 'brands', 'header' => 'brands', 'format'=>'text','value' => function($m){ return $m->getBrandProduct()['name']." "; } ],
        //['attribute' => 'h1', 'header' => 'brands', 'format'=>'text','value' => function($m){ return $m->getBrandProduct()['h1']." "; } ],

    ],
    //'columns' => ['id', 'artid', 'name', 'price', 'sort', 'active'], //without header working, because the header will be get label from attribute label.
    'headers' => [
        'id' => 'id',
        'artid' => 'artid',
        'gtin' => 'gtin',
        'name' => 'name',
        'slug' => 'slug',
        'mainImage' => 'mainImage',
        'price' => 'price',
        'sort' => 'sort',
        'active' => 'active',
        'discount_price' => 'discount_price',
        'brands'=>'brands',
        'date' => 'date',
    ],
]);
