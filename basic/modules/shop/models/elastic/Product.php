<?php
//Заметки по elastic search
$bool = 'bool. Он может включать в себя четыре типа условий: must, filter, must_not, should';
//пример с bool
$params = [
    'bool' => [
        'must' => [ //то что жолжно быть обязательно
            'match' => [
                'name' => 'BOSCH'
            ],
        ],
        'filter' => [
            'range' => [
                'price' => [
                    'gte' => 0,
                    'lte' => 8000
                ],
            ],
        ],
    ],
];
//Работает и наооборот
$params = [
    'bool' => [
        'must' => [ //то что жолжно быть обязательно
            'range' => [
                'price' => [
                    'gte' => 0,
                    'lte' => 30000
                ],
            ],
        ],
        'filter' => [
            'terms' => [ //работает как или
                'cats' => ['632', '310', '306', '307'],
            ],
        ],
    ],
];
//should
$should = 'необязательное условие';
//Добавление
$model = new ElasticProduct();
$model->attributes = $elasticArray;
$model->save();
//Удаление всего
ElasticProduct::deleteAll();
//диапозон цен
$params = [
    'range' => [
        'price' => [
            'gte' => 0,
            'lte' => 30000
        ],
    ],
];
//match queries при годится
$match = 'принимают текст / число / даты, анализируют их и строят запрос.';
$params = [
    'match' => [
        'cats' => '307', //находит не смотря на то, что cats - это массив
    ],
];
//Term - не нужен, потому что
$term = 'term query находит документы, содержащие точный термин';
//Пока не до конца понятно как работает
$params = [
    'bool' => [
        'must' => [
            [ // логическое и
                'bool' => [
                    'should' => [
                        'bool' => [
                            'must' => [
                                'terms' => [  // логическое или
                                    'cats' => ['307', '631'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [ // логическое и
                'bool' => [
                    'should' => [
                        [
                            'bool' => [
                                'must' => [
                                    'terms' => [ // логическое или
                                        'cats' => [ '640', '909'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [ // логическое и
                'bool' => [
                    'should' => [
                        [
                            'bool' => [
                                'must' => [
                                    'terms' => [ // логическое или
                                        'cats' => ['323',],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [ // логическое и
                'bool' => [
                    'should' => [
                        [
                            'bool' => [
                                'must' => [
                                    'terms' => [ // логическое или
                                        'cats' => ['133',],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
//Пример конструкции с сайта https://gist.github.com/ArFeRR/97671e54515dfd7be012 и https://habr.com/post/229905/
$params = [
    'bool' => [
        'filter' => [
            'bool' => [
                'must' => [
                    [
                        'bool' => [
                            'should' => [
                                'bool' => [
                                    'must' => [
                                        'term' => [
                                            'cats' => '632',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'bool' => [
                            'should' => [
                                'bool' => [
                                    'must' => [
                                        'term' => [
                                            'cats' => '307',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];