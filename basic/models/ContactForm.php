<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            /*
            [['email', 'phone'], 'required'],
            // name has to be a valid name
            ['name', 'required', 'message' => 'Проверть заполнение поля с именем.'],
            // email has to be a valid email address
            ['email', 'email', 'message' => 'Проверть написание почты.'],
            // phone has to be a valid phone number
            ['phone', 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{4,10}$/'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
            //*/
            // name has to be a valid name
            //['name', 'required', 'message' => 'Проверть заполнение поля с именем.'],
            // email has to be a valid email address
            //[['email', 'email'], 'required', 'message' => 'Проверть написание почты.'],
            // phone has to be a valid phone number
            //[['phone'], 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{4,10}$/' ],
			//], 'required', 'message' => 'Проверть написание телефона.'
            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha', 'message' => 'Проверьте парвильность ввода проверочного кода.'],
            //new rule
            [['body'], 'string'],
            [['email', 'phone'], 'required'],
            ['name', 'required', 'message' => 'Проверть заполнение поля с именем.'],
            ['email', 'email', 'message' => 'Проверть написание почты.'],
            [['phone'], 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{4,10}$/' ],
        ];
        /* for example
        return [
            [['name', 'minimum_order_amount', 'time_order_open', 'time_order_close', 'delivery_fee', 'rank', 'halal', 'featured', 'working_opening_hours', 'working_closing_hours', 'disable_ordering', 'delivery_duration', 'phone_number', 'longitude', 'latitude', 'image', 'status', 'owner_id', 'user_id'], 'required'],
            [['minimum_order_amount', 'delivery_fee', 'rank', 'longitude', 'latitude'], 'number'],
            [['time_order_open', 'time_order_close', 'working_opening_hours', 'working_closing_hours', 'created_at', 'updated_at'], 'safe'],
            [['halal', 'featured', 'disable_ordering', 'delivery_duration', 'status', 'owner_id', 'user_id'], 'integer'],
            [['name', 'phone_number', 'image'], 'string', 'max' => 255],
            [['working_opening_hours','working_closing_hours','time_order_open', 'time_order_close'], 'date', 'format' => 'H:m:s'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Owners::className(), 'targetAttribute' => ['owner_id' => 'id']],
            [['phone_number'], 'match', 'pattern' => '/((\+[0-9]{6})|0)[-]?[0-9]{7}/'],
        ];
        // end example */
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Капча',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            //return false;
            //var_export($this->body);
            //exit;
            $message = 'Name:' . $this->name . '<br>Email: ' . $this->email . '<br>Phone: ' . $this->phone . ' <br>Body: ' . $this->body;
            //*
            Yii::$app->mailer->compose()
                //->setTo('administrator@apfy.ru')
                ->setTo('administrator@apfy.ru', 'straengel@yandex.ru', 'straengel@gmail.com') //вроде как сработало
                //->setTo(['administrator@apfy.ru', 'straengel@yandex.ru', 'straengel@gmail.com']) //вроде как тоже работает
                //->setTo('straengel@gmail.com')
                ->setFrom([$email => 'Контактная форма'])
                ->setSubject('Сообщение с контактной формы Apfy.ru')
                ->setHtmlBody($message)
                //->setTextBody($this->body)
                ->send();
            //*/
            return true;
        }
        return false;
    }
}
