<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 30.11.2016
 * Time: 20:49
 * max_level - максимальный уровень вложенности
 * with_ParentId - выбирает по parent_id
 * with_id - выбирает по id
 * все выше перечисленные переменные имеют значение null по умолчанию
 * если нет with_id, то действует выбирает по with_ParentId (parent_id)
 * на будущие:
 * - сделать возможность выбора категорий товары или статье или еще какая нить хни )))
 */
namespace app\widgets\basket;
use Yii;
use yii\base\Widget;



class BasketWidget extends Widget{
    public $id_menu;
    public $tmp = 'index';
    public function init(){
        parent::init();
    }

    public function getItems(){

    }

    public function getOrder(){

    }

    public function run(){
        $order = '';
        return $this->render($this->tmp, [
            'order'=>$order,
        ]);
    }

}
?>