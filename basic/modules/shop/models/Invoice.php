<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 03.04.2018
 * Time: 20:48
 */

namespace app\modules\shop\models;

use Yii;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\helpers\Json;


class Invoice extends ActiveRecord
{
    /**
     * Добавление оплаты через сбербанк
     * @param integer|null $orderId Идентификатор заказа
     * @param float $price Цена заказа
     * @param int|null $remoteId Идентификатор заказа из api
     * @param array $data Массив дополнительные данных
     * @return self
     *        0            Обработка запроса прошла без системных ошибок.
     *        1            Заказ с таким номером уже зарегистрирован в системе.
     *        3            Неизвестная (запрещенная) валюта.
     *        4            Отсутствует обязательный параметр запроса.
     *        5            Ошибка значения параметра запроса.
     *        7            Системная ошибка.
     */
    /*
    static $status = [
        'Обработка запроса прошла без системных ошибок.',
        'Заказ с таким номером уже зарегистрирован в системе.',
        'Ожидание ответа от банка!',
        'Неизвестная (запрещенная) валюта.',
        'Отсутствует обязательный параметр запроса.',
        'Ошибка значения параметра запроса.',
        'Ожидание ответа от банка!',
        'Системная ошибка.',
    ];
    */
    static $status = [
        'Заказ зарегистрирован, но не оплачен.',
        'Предавторизованная сумма захолдирована (для двухстадийных платежей).',
        'Проведена полная авторизация суммы заказа.',
        'Авторизация отменена.',
        'По транзакции была проведена операция возврата.',
        'Инициирована авторизация через ACS банка-эмитента.',
        'Ожидание ответа от банка!',
        'Авторизация отклонена.',
    ];

    public static function addSberbank($orderId = null, $price, $remoteId = null, $data = [])
    {
        if (empty($orderId) && empty($remoteId)) {
            throw new InvalidParamException('Обязательно должен присутствовать идентификатор локального заказа или с удаленного сервиса');
        }
        $model = new self();
        $model->order_id = $orderId;
        $model->remote_id = $remoteId;
        $model->method = 'Сбер';
        $model->sum = $price;
        $model->status = 0;
        $model->data = $data;
        $model->save();
        return $model;
    }

//    public function afterFind()
//    {
//        parent::afterFind();
//        if ($this->data) {
//            $this->data = Json::decode($this->data);
//        }
//    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['user_id', 'order_id', 'remote_id'], 'integer'],
            [['order_id', 'status'], 'integer'],
            [['sum'], 'number'],
            [['pay_time'], 'safe'],
            [['remote_id'], 'string', 'max' => 64],
            [['method', 'message'], 'string', 'max' => 64],
            [['data'], 'string', 'max' => 1024],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
//            'user_id' => 'User ID',
            'order_id' => 'Номер заказа',
            'remote_id' => 'Номер Сбера',
            'sum' => 'Сумма к оплате',
            'status' => 'Статус',
//            'created_at' => 'Дата создания',
            'pay_time' => 'Время покупки',
            'method' => 'Метод оплаты',
            'message' => 'Ответ банка',
//            'orderId' => 'Еще какой-то метод доставки',
        ];
    }

//    public function setInvoice($model)
//    {
//        $this->_label = trim($value);
//    }

    public function getNameStatus($id){
        return Invoice::$status[$id];
    }
    public function getAllNameStatus(){
        return Invoice::$status;
    }
}