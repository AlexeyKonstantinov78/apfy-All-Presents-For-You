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
        'name' => 'mouse',
        'password' => 'XJ4Bk7ppbSuHuadYEby5',
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
            [['status'], 'integer'],
            [['data_create', 'date_last_visit'], 'safe'],
            [['mail'], 'string', 'max' => 128],
            ['mail', 'email', 'message' => 'Проверть написание почты.'],
            [['password'], 'string', 'max' => 64],
            [['name', 'lastname', 'surname'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 18],
            [['mail'], 'unique'],
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
            'data_create' => 'Дата создания',
            'date_last_visit' => 'Дата последнего визита',
        ];
    }

    public function is_root(){
        if(\Yii::$app->user->identity->id == self::$root['id'])
            return true;
        return false;
    }
    public function is_user(){
        if(findIdentity(\Yii::$app->user->identity->id) !== null && \Yii::$app->user->identity->id !== 0)
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
        if($u->name == 'mouse' && $u->password == self::$root['password']) return new static(self::$root);
        return false;
    }

    public static function findByMail($mail)
    {
        $password = self::hashPassword($mail);
        //var_dump(static::find()->where(['mail' => $mail->mail, 'password' => $password])->one());
        //var_dump($password);
        // var_dump(static::find()->where(['mail' => $mail->mail, 'password' => 'pfqrj2008gjghsu3md'])->one());
        //var_dump(static::find()->where(['id' => $mail->id,'password' => self::hashPassword($u)])->one());
        //exit;
        return static::find()->where(['mail' => $mail->mail, 'password' => $password])->one();
    }

    public static function findUserByMail($mail){
        //b114ebdbd2746e44e427e4613cfbb89ce3f0bb5a
        //$u = self::findByMail($mail);

        //echo $password;
        //var_dump(static::find()->where(['mail' => $mail->mail, 'password' => $password])->one());
        //var_dump($u);
       // var_dump(static::find()->where(['mail' => $mail->mail, 'password' => 'pfqrj2008gjghsu3md'])->one());
        //var_dump(static::find()->where(['id' => $u->id,'password' => self::hashPassword($u)])->one());
        //exit;
       // if($u->name == 'root' && $u->password == self::$root['password']) return new static(self::$root);
        $password = self::hashPassword($mail);
        return static::find()->where(['mail' => $mail->mail, 'password' => $password])->one();
        //return static::find()->where(['id' => $u->id, 'password' => 'pfqrj2008gjghsu3md'])->one();
    }

    public static function findByUserPhone($u)
    {
        return static::find()->where(['phone' => $u])->one();
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
    public function hashPassword($p)
    {
        /*
        var_dump($p->mail);
        var_dump($p->password);
        var_dump(Yii::$app->params['solt']);
        var_dump(sha1(Yii::$app->params['solt'].$p->password.$p->mail));
        exit;
        */
        $r = sha1(Yii::$app->params['solt'].$p->password.$p->mail);
        return $r;
    }


}
