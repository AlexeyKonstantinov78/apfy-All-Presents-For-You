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
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'/css/site/font-awesome.min.css',
        //'/css/site/general.css',
        //'/js/plugins/fancybox2/jquery.fancybox.change.css',
		//'/css/site/pagesCss/main.css',
		//'/css/site/pagesCss/category.css',
		//'/css/site/pagesCss/product.css'
		//'/css/site/zip.css'
		//'/css/default.css',

        '/css/site/general.css',
        [
            'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700',
            'rel' => 'preload'
        ],
        [
            '/css/site/font-awesome.min.css',
            //'rel' => 'preload'
        ],
//        '/js/plugins/fancybox2/jquery.fancybox.css',
//        '/js/plugins/fancybox2/helpers/jquery.fancybox-buttons.css',
//        '/js/plugins/fancybox2/helpers/jquery.fancybox-thumbs.css',
    ];

    // придумать как сократить js
    public $js = [

        //'/js/site/parallax.min.js',
        
//		'/js/plugins/fancybox2/jquery.mousewheel.pack.js',
//		'/js/plugins/fancybox2/jquery.fancybox.pack',
//		'/js/plugins/fancybox2/helpers/jquery.fancybox-thumbs.js',
//		'/js/plugins/fancybox2/helpers/jquery.fancybox-media.js',
//        '/js/site/zip.js',
        '/js/site/pages/item.js',
        '/js/site/general.js',
        '/js/mvc/model/Cart.js',
        '/js/mvc/controller/cartController.js',
        '/js/mvc/controller/orderController.js',
        '/js/plugins/inputMask/inputmask.min.js',
//		'/js/site/pages/category.js'
		//'/js/site/zip.js'
        //'/js/bootstrap.min.js',
        //'/js/site/allZip.js',
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
