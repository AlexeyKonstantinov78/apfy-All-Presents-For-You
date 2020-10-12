<?php
namespace app\modules\cabinet\models;

class UserDelivery extends \yii\db\ActiveRecord {

    static $delivery = ['Доставка силами APFY.RU', 'Транспортной Компанией СДЭК (по всей России)'];
    static $delivery_choose = ['Курьер', 'ПВЗ'];

    public static function tableName()
    {
        return 'user_delivery';
    }

    public function rules()
    {
        return [
            [['town', 'street', ], 'required'],
            [['town', 'street',], 'string', 'max' => 64], //Город, улица
            [['house', 'apartment', 'corps'], 'string', 'max' => 16], //Дом, квартира, корпус
            [['entrance', 'floor', 'delivery',], 'integer'], //подъезд, этаж,
        ];
    }
    /*
    public function rules()
    {
        return [
            [['town', 'street', 'delivery', 'delivery_choose',], 'required'],
            [['town', 'street', 'delivery_choose'], 'string', 'max' => 64], //Город, улица
            [['house', 'apartment', 'corps'], 'string', 'max' => 16], //Дом, квартира, корпус
            [['entrance', 'floor', 'delivery',], 'integer'], //подъезд, этаж,
        ];
    }
/**/
    public function attributeLabels()
    {
        return [
            'id' => 'Индификатор',
            'town' => 'Город',
            'street' => 'Улица',
            'house' => 'Дом',
            'corps' => 'Корпус',
            'apartment' => 'Квартира',
            'entrance' => 'Подъезд',
            'floor' => 'Этаж',
            //Силами apfy или Транспортной компанией какой-нить
            //'delivery' => 'Способ доставки (Москва-Россия)',
            //Курьер или самовывоз
            //'delivery_choose' => 'Как будет осуществлена доставка',
            'user_id' => 'Пользователь доставки',
        ];
    }

    //Курьер или самовывоз
    public function getNameDeliveryCh($id){
        return UserDelivery::$delivery_choose[$id];
    }

    //Силами apfy или Транспортной компанией какой-нить
    public function getNameDelivery($id){
        return UserDelivery::$delivery[$id];
    }


    //Курьер или самовывоз
    public function getNameDeliveryChoose($id){
        return UserDelivery::$delivery_choose[$id];
    }
}