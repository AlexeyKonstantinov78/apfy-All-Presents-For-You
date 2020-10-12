<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;


/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class OwlAsset extends AssetBundle
{

    public $sourcePath = '@npm/owl.carousel/dist';
    public $js = [

        [
            'owl.carousel.min.js',
            //'rel' => 'preload'
        ],
    ];

    public $css = [
        [
            'assets/owl.carousel.min.css',
            //'rel' => 'preload'
        ],
        [
            'assets/owl.theme.default.min.css',
            'rel' => 'preload'
        ],
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
    /* async opiton and other for added
    public $jsOptions = [
        'async' => 'async',
    ];
    /**/
}
