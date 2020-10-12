<?php
use Yii;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Menu;
use app\models\Order;

function dropdownmenu($controller_id, $drop_menu){
    if (in_array($controller_id, $drop_menu)) {
        $drop_active['aria-expanded'] = 'aria-expanded="true"';
        $drop_active['class'] = 'in';
    }
    else {
        $drop_active['aria-expanded'] = 'aria-expanded="false"';
        $drop_active['class'] = '';
    }
    return $drop_active;
}
$drop_menu = dropdownmenu(Yii::$app->controller->id, ['shop/product', 'shop/product_option', 'shop/product_attribute',]);
$drop_menu2 = dropdownmenu(Yii::$app->controller->id, ['articles', 'articlecategory']);
$root_feedback = $root_back = null;
/*
$menu_widget_items_new_variant = [
    ['label' => 'Категории',
        'url' => '/root/shop/category',
        'template' => '<a href="{url}"><i class="fa fa-fw fa-dashboard"></i> {label} </a>',
        'active'=> Yii::$app->controller->id == 'shop/category',
    ],
    ['label' => 'Товары',
        'url' => '',
        'template' => '<a href="javascript:;" data-toggle="collapse" data-target="#product" '.$drop_menu['aria-expanded'].'><i class="fa fa-bars" aria-hidden="true"></i> {label} </a>',
        'items' => [
            ['label' => 'Список товаров',
                'url' => '/root/shop/product',
                'template' => '<a href="{url}"><i class="fa fa-fw fa-product-hunt" ></i> {label} </a>',
                'active'=> Yii::$app->controller->id == 'shop/product',
            ],
            ['label' => 'Атрибуты товаров',
                'url' => '/root/shop/product_attribute',
                'template' => '<a href="{url}"><i class="fa fa-fw fa-tasks" ></i> {label} </a>',
                'active'=> Yii::$app->controller->id == 'shop/product_attribute',
            ],
        ],
        'submenuTemplate' => '<ul id="product" class="collapse '.$drop_menu['class'].'" '.$drop_menu['aria-expanded'].'>{items}</ul>',
    ],
    ['label' => 'Статьи',
        'url' => '',
        'template' => '<a href="javascript:;" data-toggle="collapse" data-target="#articles" '.$drop_menu2['aria-expanded'].'><i class="fa fa-bars" aria-hidden="true"></i> {label} </a>',
        'items' => [
            ['label' => 'Категории',
                'url' => '/root/articlecategory',
                'template' => '<a href="{url}"><i class="fa fa-fw fa-list-alt" ></i> {label} </a>',
                'active'=> Yii::$app->controller->id == 'articlecategory',
            ],
            ['label' => 'Статьи',
                'url' => '/root/articles',
                'template' => '<a href="{url}"><i class="fa fa-fw fa-file-text-o" ></i> {label} </a>',
                'active'=> Yii::$app->controller->id == 'articles',
            ],
        ],
        'submenuTemplate' => '<ul id="articles" class="collapse '.$drop_menu2['class'].'" '.$drop_menu2['aria-expanded'].'>{items}</ul>',
    ],
    ['label' => 'Заказы',
        'url' => '/root/shop/order',
        'template' => '<a href="{url}"><i class="fa fa-fw fa-cart-arrow-down"></i> {label} </a>',
        'active'=> Yii::$app->controller->id == 'order',
    ],
    ['label' => 'Страницы',
        'url' => '/root/page',
        'template' => '<a href="{url}"><i class="fa fa-fw fa-file"></i> {label}</a>',
        'active'=> Yii::$app->controller->id == 'page',
    ],
    ['label' => 'Баннеры',
        'url' => '/root/bannergroups',
        'template' => '<a href="{url}"><i class="fa fa-fw fa-book"></i> {label}</a>',
        'active'=> Yii::$app->controller->id == 'bannergroups',
    ],
    ['label' => 'Настройки',
        'url' => '/root/settings',
        'template' => '<a href="{url}" ><i class="fa fa-fw fa-gear"></i> {label} </a>',
        'active'=> Yii::$app->controller->id == 'settings',
    ],
    ['label' => 'Сообщение',
        'url' => '/root/feedback',
        'template' => '<a href="{url}" ><i class="fa fa-fw fa-gear"></i> {label} </a>',
        'active'=> Yii::$app->controller->id == 'feedback',
    ],
    ['label' => 'Главная',
        'url' => '/root/',
        'template' => '<a href="{url}"><i class="fa fa-fw fa-user"></i> {label} </a>',
        'active'=> Yii::$app->controller->id == 'default',
    ],
];
$menu_widget_items_old_variant = [
    ['label' => 'Категории',
        'url' => '/root/shop/category',
        'template' => '<a href="{url}"><i class="fa fa-fw fa-dashboard"></i> {label} </a>',
        'active'=> Yii::$app->controller->id == 'shop/category',
    ],
    ['label' => 'Товары',
        'url' => '',
        'template' => '<a href="javascript:;" data-toggle="collapse" data-target="#product" '.$drop_menu['aria-expanded'].'><i class="fa fa-bars" aria-hidden="true"></i> {label} </a>',
        'items' => [
            ['label' => 'Список товаров',
                'url' => '/root/shop/product',
                'template' => '<a href="{url}"><i class="fa fa-fw fa-product-hunt" ></i> {label} </a>',
                'active'=> Yii::$app->controller->id == 'shop/product',
            ],
            /*['label' => 'Опции товаров',
                'url' => '/root/shop/product_option',
                'template' => '<a href="{url}"><i class="fa fa-fw fa-desktop"></i> {label} </a>',
                'active'=> Yii::$app->controller->id == 'shop/product_option',
            ],
            ///
            ['label' => 'Атрибуты товаров',
                'url' => '/root/shop/product_attribute',
                'template' => '<a href="{url}"><i class="fa fa-fw fa-tasks" ></i> {label} </a>',
                'active'=> Yii::$app->controller->id == 'shop/product_attribute',
            ],
        ],
        'submenuTemplate' => '<ul id="product" class="collapse '.$drop_menu['class'].'" '.$drop_menu['aria-expanded'].'>{items}</ul>',
    ],
    /*
    ['label' => 'Статьи',
        'url' => '',
        'template' => '<a href="javascript:;" data-toggle="collapse" data-target="#articles" '.$drop_menu2['aria-expanded'].'><i class="fa fa-bars" aria-hidden="true"></i> {label} </a>',
        'items' => [
            ['label' => 'Категории',
                'url' => '/root/articlecategory',
                'template' => '<a href="{url}"><i class="fa fa-fw fa-list-alt" ></i> {label} </a>',
                'active'=> Yii::$app->controller->id == 'articlecategory',
            ],
            ['label' => 'Статьи',
                'url' => '/root/articles',
                'template' => '<a href="{url}"><i class="fa fa-fw fa-file-text-o" ></i> {label} </a>',
                'active'=> Yii::$app->controller->id == 'articles',
            ],
        ],
        'submenuTemplate' => '<ul id="articles" class="collapse '.$drop_menu2['class'].'" '.$drop_menu2['aria-expanded'].'>{items}</ul>',
    ],

    ['label' => 'Меню',
        'url' => '/root/menu',
        'template' => '<a href="{url}"><i class="fa fa-fw fa-list-ul"></i> {label}</a>',
        'active'=> Yii::$app->controller->id == 'menu',
    ],
    ///
    ['label' => 'Заказы',
        'url' => '/root/shop/order',
        'template' => '<a href="{url}"><i class="fa fa-fw fa-cart-arrow-down"></i> {label} </a>',
        'active'=> Yii::$app->controller->id == 'order',
    ],
    ['label' => 'Страницы',
        'url' => '/root/page',
        'template' => '<a href="{url}"><i class="fa fa-fw fa-file"></i> {label}</a>',
        'active'=> Yii::$app->controller->id == 'page',
    ],
    ['label' => 'Баннеры',
        'url' => '/root/bannergroups',
        'template' => '<a href="{url}"><i class="fa fa-fw fa-book"></i> {label}</a>',
        'active'=> Yii::$app->controller->id == 'bannergroups',
    ],
    /*
    ['label' => 'Настройки',
        'url' => '/root/settings',
        'template' => '<a href="{url}" ><i class="fa fa-fw fa-gear"></i> {label} </a>',
        'active'=> Yii::$app->controller->id == 'settings',
    ],
    ///
    ['label' => 'Сообщение',
        'url' => '/root/feedback',
        'template' => '<a href="{url}" ><i class="fa fa-fw fa-gear"></i> {label} </a>',
        'active'=> Yii::$app->controller->id == 'feedback',
    ],
    ['label' => 'Главная',
        'url' => '/root/',
        'template' => '<a href="{url}"><i class="fa fa-fw fa-user"></i> {label} </a>',
        'active'=> Yii::$app->controller->id == 'default',
    ],
];
*/
$count_message = Order::find()->where(['status'=>'0'])->count(); //количество уведомлений

//*
$menu_widget = [
    'items' => [
        //*
        ['label' => 'Главная',
            'url' => '/root/',
            'template' => '<a href="{url}"> {label} </a>',
            'active'=> Yii::$app->controller->id == 'default',
        ],
        //*/
        ['label' => 'Товары и Категории',
            'url' => ['#'],
            'options'=>['class'=>'dropdown'],
            'template' => '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gg" aria-hidden="true"></i> {label} <b class="caret"></b></a>',
            'items' => [
                ['label' => 'Список товаров',
                    'url' => '/root/shop/product',
                    'template' => '<a href="{url}"><i class="fa fa-fw fa-product-hunt" ></i> {label} </a>',
                    'active'=> Yii::$app->controller->id == 'shop/product',
                ],
                ['label' => 'Атрибуты товаров',
                    'url' => '/root/shop/product_attribute',
                    'template' => '<a href="{url}"><i class="fa fa-fw fa-tasks" ></i> {label} </a>',
                    'active'=> Yii::$app->controller->id == 'shop/product_attribute',
                ],
                ['label' => 'Категории и фильтры',
                    'url' => '/root/shop/category',
                    'template' => '<a href="{url}"><i class="fa fa-fw fa-dashboard"></i> {label} </a>',
                    'active'=> Yii::$app->controller->id == 'shop/category',
                ],
            ],
        ],
        ['label' => 'Экспорт/Импорт',
            'url' => ['#'],
            'options'=>['class'=>'dropdown'],
            'template' => '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-coffee" aria-hidden="true"></i> {label} <b class="caret"></b></a>',
            'items' => [
                ['label' => 'Экспорт товаров Excel',
                    'url' => '/root/shop/productexcel/export',
                    'template' => '<a href="{url}"><i class="fa fa-fw fa-download"></i> {label} </a>',
                    'active'=> Yii::$app->controller->id == 'shop/productexcel',
                ],
                ['label' => 'Импорт товаров Excel',
                    'url' => '/root/shop/productexcel/import',
                    'template' => '<a href="{url}"><i class="fa fa-fw fa-upload"></i> {label} </a>',
                    'active'=> Yii::$app->controller->id == 'shop/productexcel',
                ],
//                ['label' => 'Пакетная загрузка товаров из других систем',
//                    'url' => '/root/shop/productintegration/file',
//                    'template' => '<a href="{url}"><i class="fa fa-fw fa-upload"></i> {label} </a>',
//                    'active'=> Yii::$app->controller->id == 'shop/productintegration',
//                ],
                ['label' => 'Импорт пвз',
                    'url' => '/root/excel/importpvz',
                    'template' => '<a href="{url}"><i class="fa fa-fw fa-download"></i> {label} </a>',
                    'active'=> Yii::$app->controller->id == 'excel',
                ],
            ],
        ],
        //*
        ['label' => 'Статьи',
            'url' => ['#'],
            'options'=>['class'=>'dropdown'],
            'template' => '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars" aria-hidden="true"></i> {label} <b class="caret"></b></a>',
            'items' => [
                ['label' => 'Категории статей',
                    'url' => '/root/articlecategory',
                    'template' => '<a href="{url}"><i class="fa fa-fw fa-list-alt" ></i> {label} </a>',
                    'active'=> Yii::$app->controller->id == 'articlecategory',
                ],
                ['label' => 'Статьи',
                    'url' => '/root/articles',
                    'template' => '<a href="{url}"><i class="fa fa-fw fa-file-text-o" ></i> {label} </a>',
                    'active'=> Yii::$app->controller->id == 'articles',
                ],
                ['label' => 'Страницы',
                    'url' => '/root/page',
                    'template' => '<a href="{url}"><i class="fa fa-fw fa-file"></i> {label}</a>',
                    'active'=> Yii::$app->controller->id == 'page',
                ],
            ],
        ],
        //*/
        //уведомления о заказах, сообщениях
        ['label' => 'Уведомления',
            'url' => ['#'],
            'options'=>['class'=>'dropdown'],
            'template' => '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-address-card-o" aria-hidden="true"></i> {label} ('.$count_message.')<b class="caret"></b></a>',
            //'url' => '',
            //'template' => '<a href="javascript:;" data-toggle="collapse" data-target="#product" '.$drop_menu['aria-expanded'].'><i class="fa fa-bars" aria-hidden="true"></i> {label} </a>',
            'items' => [
                ['label' => 'Заказы',
                    'url' => '/root/shop/order',
                    'template' => '<a href="{url}"><i class="fa fa-fw fa-cart-arrow-down"></i> {label} </a>',
                    'active'=> Yii::$app->controller->id == 'order',
                ],
                ['label' => 'Тикет',
                    'url' => '#',
                    'template' => '<a href="{url}"><i class="fa fa-fw fa-weixin"></i> {label} </a>',
                    'active'=> Yii::$app->controller->id == 'order',
                ],
                ['label' => 'Обратная связь',
                    'url' => '/root/feedback',
                    'template' => '<a href="{url}" ><i class="fa fa-fw fa-gear"></i> {label} </a>',
                    'active'=> Yii::$app->controller->id == 'feedback',
                ],
            ],
        ],
        ['label' => 'Модули',
            'url' => ['#'],
            'options'=>['class'=>'dropdown'],
            'template' => '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list-ul" aria-hidden="true"></i> {label}<b class="caret"></b></a>',
            //'url' => '',
            //'template' => '<a href="javascript:;" data-toggle="collapse" data-target="#product" '.$drop_menu['aria-expanded'].'><i class="fa fa-bars" aria-hidden="true"></i> {label} </a>',
            'items' => [
                ['label' => 'Баннеры',
                    'url' => '/root/bannergroups',
                    'template' => '<a href="{url}"><i class="fa fa-fw fa-book"></i> {label}</a>',
                    'active'=> Yii::$app->controller->id == 'bannergroups',
                ],
                ['label' => 'Страницы',
                    'url' => '/root/page',
                    'template' => '<a href="{url}"><i class="fa fa-fw fa-file"></i> {label}</a>',
                    'active'=> Yii::$app->controller->id == 'page',
                ],
                //*/
            ],
        ],

        //имя пользователя, настройки, выход
        ['label' => Yii::$app->user->identity->name,
            'url' => ['#'],
            'options'=>['class'=>'dropdown'],
            'template' => '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {label} <b class="caret"></b></a>',
            'items' => [
                ['label' => 'Пользователи',
                    //'url' => '/root/settings',
                    'url' => '#',
                    'template' => '<a href="{url}" ><i class="fa fa-fw fa-user"></i> {label} </a>',
                    'active'=> Yii::$app->controller->id == 'cabinet',
                ],
                ['label' => 'Тикет',
                    'url' => '#',
                    'template' => '<a href="{url}"><i class="fa fa-fw fa-weixin"></i> {label} </a>',
                    'active'=> Yii::$app->controller->id == 'order',
                ],
                ['label' => 'Рассылка',
                    //'url' => '/root/settings',
                    'url' => '#',
                    'template' => '<a href="{url}" ><i class="fa fa-fw fa-rss-square"></i> {label} </a>',
                    'active'=> Yii::$app->controller->id == 'cabinet',
                ],
                ['label' => 'Настройки',
                    'url' => '/root/settings',
                    //'url' => '#',
                    'template' => '<a href="{url}" ><i class="fa fa-fw fa-gear"></i> {label} </a>',
                    'active'=> Yii::$app->controller->id == 'settings',
                ],
                "4" => $root_back,
                ['label' => 'Выйти',
                    'url' => '#',
                    'template' =>
                        '<form class="navbar-form forms-label-admin" action="/root/logout" method="post">
                        <input type="hidden" name="_csrf" value="'.Yii::$app->request->getCsrfToken().'">
                        <button type="submit" class="btn btn-link ">
                            <i class="fa fa-fw fa-power-off"></i> Выйти ('.Yii::$app->user->identity->name.')
                        </button>
                        </form>',
                ],
            ],
        ],
    ],
    'options' => [
        'class' => 'nav navbar-right top-nav',
    ],
    'activeCssClass' => 'active',
    'encodeLabels' =>'false',
    'submenuTemplate' => '<ul class="dropdown-menu">{items}</ul>',

];
//echo Yii::$app->useroot->identity->username;
//exit();
echo Menu::widget($menu_widget);
?>

<?php
//backup
/* это коментить при восстановлении
//use Yii;
//use yii\widgets\Menu;
$root_feedback = $root_back = null;
$menu_widget = [
    'items' => [
        ['label' => Yii::$app->user->identity->username,
            'url' => ['#'],
            'options'=>['class'=>'dropdown'],
            'template' => '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {label} <b class="caret"></b></a>',
            'items' => [
                /*
                ['label' => 'Настройки',
                    'url' => '#',
                    'template' => '<a href="#"><i class="fa fa-fw fa-gear"></i> {label}</a>'
                ],
                //*/
/* это коментить при восстановлении
"1" => $root_back,
['label' => 'Выйти',
    'url' => '#',
    'template' =>
        '<form class="navbar-form forms-label-admin" action="/root/logout" method="post">
<input type="hidden" name="_csrf" value="'.Yii::$app->request->getCsrfToken().'"><button type="submit" class="btn btn-link "><i class="fa fa-fw fa-power-off"></i> Выйти ('.Yii::$app->user->identity->username.')</button></form>',
],
]
],
],
'options' => [
'class' => 'nav navbar-right top-nav',
],
'activeCssClass' => 'active',
'encodeLabels' =>'false',
'submenuTemplate' => '<ul class="dropdown-menu">{items}</ul>',

];

echo Menu::widget($menu_widget);
//*/
?>
