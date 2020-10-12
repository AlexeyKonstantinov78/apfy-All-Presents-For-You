<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 26.05.2017
 * Time: 1:42
 */
use Yii;
use yii\widgets\Menu;
$root_feedback = $root_back = null;
$menu_widget = [
    'items' => [
        ['label' => Yii::$app->user->identity->username,
            'url' => ['#'],
            'options'=>['class'=>'dropdown'],
            'template' => '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {label} <b class="caret"></b></a>',
            'items' => [

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
?>