<?php

namespace app\modules\shop\models;

use Yii;
use app\modules\shop\models\Product;
use app\modules\shop\models\OrderItem;
use app\modules\shop\models\Invoice;
/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $adress
 * @property string $comment
 * @property double $total
 * @property integer $status
 * @property string $date_create
 * @property string $date_edit
 * @property integer $user_id
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    CONST STATUS_NEW = 0;
    CONST STATUS_WAIT = 1;
    CONST STATUS_SUCCESS = 2;
    CONST STATUS_CANCEL = 3;
    static $status = [Order::STATUS_NEW => 'Новый заказ', Order::STATUS_WAIT => 'В ожидании', Order::STATUS_SUCCESS => 'выполнен', Order::STATUS_CANCEL => 'отменен'];
    static $delivery = ['Доставка силами APFY.RU', 'Транспортной Компанией СДЭК (по всей России)'];
    static $delivery_choose = ['Курьер', 'ПВЗ'];
    static $payment = ['Наличными при получении', 'Банковской картой при получении', 'Онлайн оплата', 'Онлайн оплата'];
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name',  'phone', 'email', 'town', 'street', 'delivery', 'delivery_choose', 'payment_choose'], 'required'],
            //[['name',  'phone', 'email', 'town', 'street', 'house', 'apartment', 'delivery', 'delivery_choose'], 'required'],
            [['status'], 'integer'],
            [['date_create', 'date_edit'], 'safe'],
            [['name'], 'string', 'max' => 48],
            [['email'], 'email'],
            //[['phone'], 'string', 'max' => 18],
            ['phone', 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{4,10}$/', 'message' => 'Проверьте телефон!'],
            [['town', 'street', 'delivery_choose'], 'string', 'max' => 64], //Город, улица
            [['house', 'apartment', 'corps'], 'string', 'max' => 16], //Дом, квартира, корпус
            [['terms_of_use'], 'compare', 'compareValue' => 1, 'type' => 'number', 'message' => 'Необходимо согласиться с пользовательским соглашением!'], //подъезд, этаж,
            [['entrance', 'floor', 'delivery', 'payment_choose'], 'integer'], //подъезд, этаж,
            [['comment', 'comment_more'], 'string', 'max' => 512], //комментарий
            [['total', 'delivery_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номерз аказа',
            'name' => 'ФИО',
            'email' => 'Электронная почта',
            'phone' => 'Телефон',
            'town' => 'Город',
            'street' => 'Улица',
            'house' => 'Дом',
            'corps' => 'Корпус',
            'apartment' => 'Квартира',
            'entrance' => 'Подъезд',
            'floor' => 'Этаж',
            'terms_of_use' => 'Пользовательское соглашение',
            'comment' => 'Комментарий к заказу',
            'comment_more' => 'Комментарий к заказу(если есть)',
            'total' => 'Общая цена',
            'status' => 'Статус',
            'date_create' => 'Дата покупки',
            'date_edit' => 'Дата изменения',
            'delivery' => 'Способ доставки (Москва-Россия)',
            'delivery_price' => 'Цена доставки',
            'delivery_choose' => 'Детали доставки',
            'payment_choose' => 'Способ оплаты',
        ];
    }
    public function getNameStatus($id){
        return Order::$status[$id];
    }
    public function getAllNameStatus(){
        return Order::$status;
    }
    public function getNameDeliveryCh($id){
        return Order::$delivery_choose[$id];
    }
    public function getAllNameDeliveryCh(){
        return Order::$delivery_choose;
    }
    public function getNameDelivery($id){
        return Order::$delivery[$id];
    }
    public function getAllNameDelivery(){
        return Order::$delivery;
    }
    public function getNamePayment($id){
        return Order::$payment[$id];
    }
    public function getAllNamePayment(){
        return Order::$payment;
    }

    public function getProducts(){
        $query = $this->hasMany(OrderItem::className(), ['order_id' => 'id'])->with('product');
        return $query;
    }

    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['order_id' => 'id'])->one();
    }

}
