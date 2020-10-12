<?php

//var_dump($model);

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
        'price',
        'sort',
        'active',
        'discount_price',
        ['attribute' => 'brands', 'header' => 'brands', 'format'=>'text','value' => function($m){ return $m->getBrandProduct(); } ],
        //['attribute' => 'brands', 'header' => 'brands', 'format'=>'text','value' => function($m){ return $m->getBrandProduct()['name']." "; } ],
        //['attribute' => 'h1', 'header' => 'brands', 'format'=>'text','value' => function($m){ return $m->getBrandProduct()['h1']." "; } ],

    ],
    //'columns' => ['id', 'artid', 'name', 'price', 'sort', 'active'], //without header working, because the header will be get label from attribute label.
    'headers' => [
        'id' => 'id',
        'artid' => 'artid',
        'gtin' => 'gtin',
        'name' => 'name',
        'price' => 'price',
        'sort' => 'sort',
        'active' => 'active',
        'discount_price' => 'discount_price',
        'brands'=>'brands',

    ],
]);
