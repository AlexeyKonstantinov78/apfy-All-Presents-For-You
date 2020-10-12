<?php
namespace app\models;

use Yii;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $user_name
 * @property string $user_password
 * @property string $domain
 * @property double $balance
 */

class Users extends \yii\db\ActiveRecord implements IdentityInterface
{
    private static $root = [
        'id' => 0,
        'name' => 'login',
        'password' => 'password',
    ];
    public $auth_key;

    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mail', 'password', 'phone', 'name'], 'required'],
            [['status', 'delivery_default'], 'integer'],
            [['data_create', 'date_last_visit'], 'safe'],
            [['mail'], 'string', 'max' => 128],
            ['mail', 'email', 'message' => 'Проверть написание почты.'],
            [['password'], 'string', 'max' => 64],
            [['name', 'lastname', 'surname'], 'string', 'max' => 32],
            ['phone', 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{4,10}$/', 'message' => 'Проверьте телефон!'],
            [['terms_of_use'], 'compare', 'compareValue' => 1, 'type' => 'number', 'message' => 'Необходимо согласиться с пользовательским соглашением!'], //подъезд, этаж,
            [['mail', ], 'unique', 'message' => 'Пожалуйста, введите имя пользователя'],
            [['phone'], 'unique', 'message' => 'Пожалуйста, введите имя пользователя'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->password = $this->hashPassword($this);
            } else {
                $this->password = $this->password != '' && $this->password != $this->oldAttributes['password'] ? $this->hashPassword($this) : $this->oldAttributes['password'];
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mail' => 'Почта',
            'password' => 'Пароль',
            'name' => 'Имя',
            'lastname' => 'Фамилия',
            'surname' => 'Отчество',
            'phone' => 'Телефон',
            'status' => 'Статус',
            'delivery_default' => 'Способ доставки по умолчанию',
            'data_create' => 'Дата создания',
            'date_last_visit' => 'Дата последнего визита',
        ];
    }

    public function is_root(){
        if(\Yii::$app->user->identity->id == self::$root['id'])
            return true;
        return false;
    }

    public static function findIdentity($id)
    {
        if($id === 0) return new static(self::$root);
        return static::findOne($id);

        //return $result;
    }

    public static function findByName($u)
    {
        if($u->name == 'login' && $u->password == self::$root['password']) return new static(self::$root);
        return static::find()->where(['name' => $u->name])->one();
    }

    public static function findByMail($mail)
    {
        if($mail->mail === self::$root['name'] && $mail->password == self::$root['password']){
            return new static(self::$root);
        }
        $password = self::hashPassword($mail);
        return static::find()->where(['mail' => $mail->mail, 'password' => $password])->one();
    }

    public function getId()
    {
        return $this->id;
    }

    public function validatePassword($data)
    {
        return $this->password === $this->hashPassword($data);
    }


    public function getAuthKey()
    {
        return '';
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    private function generateAuthKey()
    {
        return Yii::$app->security->generateRandomString();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return Yii::$app->session['auth_token'] == $token;

    }

    //Наверно Стереть надо будет TODO

    public static function findUserByMail($mail){
        return static::find()->where(['mail' => $mail->mail])->one();
        //return static::find()->where(['id' => $u->id, 'password' => 'passw'])->one();
    }

    public static function findByUserPhone($u)
    {
        return static::find()->where(['phone' => $u])->one();
    }
    public function hashPassword($p)
    {
        $r = sha1(Yii::$app->params['solt'].$p->password.$p->mail);
        return $r;
    }


}
