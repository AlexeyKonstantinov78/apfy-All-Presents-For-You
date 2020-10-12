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
class ItemAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //fancybox2
        //'/js/plugins/fancybox2/jquery.fancybox.change.css',
    ];

    // придумать как сократить js
    public $js = [
        //fancybox2
        //'/js/plugins/fancybox2/jquery.fancybox_2.js',
        //zoom
        //'/js/plugins/zoom/jquery.ez-plus.js',
        //itemJs
        //'/js/site/pages/item.modile.js',
        //'/js/site/pages/item.js'
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
