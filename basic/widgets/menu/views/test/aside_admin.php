<?php
use Yii;
use yii\widgets\Menu; 
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
$drop_menu2 = $this->dropdownmenu(Yii::$app->controller->id, ['articles', 'articlecategory']);
$root_feedback = $root_back = null;
$menu_widget = [
	'items' => [
		['label' => 'Главная',
			'url' => '/root/',
			'template' => '<a href="{url}"><i class="fa fa-fw fa-user"></i> {label} </a>',
			'active'=> Yii::$app->controller->id == 'default',
		],
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
				],*/
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
		],*/
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
		*/
		['label' => 'Сообщение',
			'url' => '/root/feedback',
			'template' => '<a href="{url}" ><i class="fa fa-fw fa-gear"></i> {label} </a>',
			'active'=> Yii::$app->controller->id == 'feedback',
		],
		"" => $root_feedback,


	],
	'options' => [
		'class' => 'nav navbar-nav side-nav',
	],
	'activeCssClass' => 'active',
	'encodeLabels' =>'false',
];
echo Menu::widget($menu_widget);
?>
