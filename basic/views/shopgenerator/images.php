<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 29.08.2018
 * Time: 20:57
 */
use app\helpers\Image;

foreach($models as $k=>$v){
    echo "<img src='".Image::thumb($v['image'], null, 80)."'/> <br/>";
    echo "<img src='".Image::thumb($v['image'], null, 600)."'/> <br/>";
    echo "<img src='".Image::thumb($v['image'], null, 260)."'/> <br/>";
}