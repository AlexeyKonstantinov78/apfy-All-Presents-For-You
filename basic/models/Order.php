<?php

namespace app\models;

use Yii;
use app\modules\shop\models\Product;
use app\models\OrderItem;
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
 */
class Order extends \yii\db\ActiveRecord
{
    CONST STATUS_NEW = 0;
    CONST STATUS_WAIT = 1;
    CONST STATUS_SUCCESS = 2;
    CONST STATUS_CANCEL = 3;
    static $status = [Order::STATUS_NEW => 'Новый заказ', Order::STATUS_WAIT => 'В ожидании', Order::STATUS_SUCCESS => 'выполнен', Order::STATUS_CANCEL => 'отменен'];
    /**
     * @inheritdoc
     */
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
            [['name', 'email', 'phone', 'total', 'status', 'date_create', 'date_edit'], 'required'],
            [['total'], 'number'],
            [['status'], 'integer'],
            [['date_create', 'date_edit'], 'safe'],
            [['name'], 'string', 'max' => 48],
            [['email'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 16],
            [['adress'], 'string', 'max' => 256],
            [['comment'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя покупателя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'adress' => 'Адрес',
            'comment' => 'Коментарий',
            'total' => 'Сумма заказа',
            'status' => 'Статус',
            'date_create' => 'Дата создания',
            'date_edit' => 'Дата изменения',
        ];
    }

    public function getNameStatus($id){
        return Order::$status[$id];
    }

    public function getAllNameStatus(){
        return Order::$status;
    }

    public function getProducts(){
        $query = $this->hasMany(OrderItem::className(), ['order_id' => 'id'])->with('product');
        return $query;
    }
}
