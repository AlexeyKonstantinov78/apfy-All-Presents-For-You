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
class FancyAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        [
            '/js/plugins/fancybox2/jquery.fancybox.css',
            //'rel' => 'preload'
        ],
        [
            '/js/plugins/fancybox2/helpers/jquery.fancybox-buttons.css',
            'rel' => 'preload'
        ],
        [
            '/js/plugins/fancybox2/helpers/jquery.fancybox-thumbs.css',
            'rel' => 'preload'
        ],
    ];

    // придумать как сократить js
    public $js = [
        [
            '/js/plugins/fancybox2/jquery.mousewheel.pack.js',
            'rel' => 'preload'
        ],
        [
            '/js/plugins/fancybox2/jquery.fancybox.pack.js',
            //'rel' => 'preload'
        ],
        [
            '/js/plugins/fancybox2/helpers/jquery.fancybox-thumbs.js',
            'rel' => 'preload'
        ],
        [
            '/js/plugins/fancybox2/helpers/jquery.fancybox-media.js',
            'rel' => 'preload'
        ],




    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    /* async opiton and other for added
    public $jsOptions = [
        'async' => 'async',
    ];
    /**/
}
