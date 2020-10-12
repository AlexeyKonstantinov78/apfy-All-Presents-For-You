<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 30.11.2016
 * Time: 19:11
 */
namespace app\assets;
use yii\web\AssetBundle;
class AdminAsset extends AssetBundle
{
    public $sourcePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [
        'css/root/sb-admin.css',
        //'css/site.css',
        //'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css', шрифты
        'fonts/font-awesome/css/font-awesome.min.css',
        //'css/plugins/morris.css', //css для графиков
    ];
    public $js = [
        //плагин для графиков
        //'js/plugins/morris/raphael.min.js',
        //'js/plugins/morris/morris.min.js',
        //'js/plugins/morris/morris-data.js',
        //'js/root/bootstrap.min.js',
        //'js/root/admin.js',
        //'js/yandex.map.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapAsset',
        //'app\assets\BootboxAsset',
    ];
}