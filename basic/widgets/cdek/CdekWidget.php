<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 15.03.2018
 * Time: 4:10
 */
namespace app\widgets\cdek;

use Yii;
use yii\base\Widget;

class CdekWidget extends Widget {
    public $model;

    public function run(){

        return $this->render('default',[

        ]);
    }

}