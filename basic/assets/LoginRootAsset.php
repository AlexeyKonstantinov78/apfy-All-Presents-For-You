<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 30.11.2016
 * Time: 19:11
 */
namespace app\assets;
use yii\web\AssetBundle;
class LoginRootAsset extends AssetBundle
{
    public $sourcePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [
        'css/root/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        //'app\assets\BootboxAsset',
    ];
}