<?php

namespace app\modules\cabinet\controllers;


use Yii;
use yii\web\Controller;
use app\models\Users;
use yii\base\DynamicModel;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * UsersController implements the CRUD actions for Users model.
 */
class RegistrationController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function init()
    {
        parent::init();

        if(!\Yii::$app->user->isGuest){
            if(\Yii::$app->user->identity->is_root())
                return $this->redirect('/root/');
            return $this->redirect('/cabinet/');
        }
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            if (\Yii::$app->user->id === 0) return $this->redirect('/root/');
            return $this->redirect('/cabinet/');
        }

        $model = new Users(['status'=>'0', 'data_create'=> date('Y-m-d H:i:s') ]);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if($model->save()){
                if ($f = $this->helpSendMail($model, 'checked_mail')){
                    $data['result'] = true;
                    $data['message'] = '<p>Вы успешно зарегистрировались, к Вам на почту пришло письма с подтверждением о регистрации на сайте APFY.RU!</p>';
                } else {
                    $data['result'] = false;
                    $data['message'] = '<p>Регистрация прошла успешно, но письмо для подтверждения не отправлено</p>';
                    $data['message'] .= '<p>Пожалуйста свяжитесь с администрацией сайт APFY.RU по почте administrator@apfy.ru!</p>';
                }
            } else {
                $data = ActiveForm::validate($model);
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $data;
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

    public function actionReset(){
        //подумать как лучше отсылать письма
        /*
        $model = new DynamicModel(['mail']);
        $model  ->addRule(['mail'], 'email', ['message' => 'Проверть написание почты.'])
            ->addRule(['terms_of_use'], 'compare', ['compareValue' => 1, 'type' => 'number', 'message' => 'Необходимо согласиться с пользовательским соглашением!']);
        /**/
        $model = new DynamicModel(['mail']);
        $model ->addRule(['mail'], 'email', ['message' => 'Проверть написание почты.']);

        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $findUser = Users::find()->where(['mail' => $model->mail])->one();

            if ($findUser !== null) {
                $findUser->password = $this->helpSendMail($findUser, 'new_password');
                $findUser->save();
                $message = 'Вы успешно восстановили изменили пароль';
                $result= [
                    'result' => true,
                    'message' => $message
                ];
            } else {
                $message = 'Такая почта не зарегистрирована!';
                $result = [
                    'result' => false,
                    'message' => $message
                ];
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;

            /*return $this->render('message', [
                'message' => $message,
            ]);*/
        } else {
            return $this->render('resetPassword', [
                'model' => $model,
            ]);
        }
    }

    public function actionRepeatconfirmmail($send){
        if(Yii::$app->request->isAjax) {
            $info = [
                'mail' => \Yii::$app->user->identity->mail,
                'password' => \Yii::$app->user->identity->password,
            ];

            $this->helpSendMail($info, 'repeat_send');
        }
    }

    private function helpSendMail($info, $action)
    {
        $mes = true;
        if($action == 'checked_mail') {
            $subject = 'Подтверждение регистрации на сайте! Apfy.ru';
            $setFormTxt = 'Подтверждение регистрации на сайте!';
            $message = 'Администрация сайта благодарит Вас за регистрацию и просит пройти по ссылки для подтверждения регистрации.';
            $message = '<a href="https://apfy.ru/site/confirm?href='.$info->password.'&m='.$info->mail.'">';
            $message = 'https://apfy.ru/site/confirm?href='.$info->password.'&m='.$info->mail;
            $message = '</a>';
            $mail = $info->mail;
        } else if($action == 'reset_password') {
            $subject = 'Восстановление пароля! Apfy.ru';
            $setFormTxt = 'Восстановление пароля! на сайте!';
            $message = 'Восстановление пароля.';
            $message .= '<a href="https://apfy.ru/site/confirm?m='.$info->mail.'&reset=true">';
            $message .= '    Перейдите по ссылки для восстановления пароля';
            $message .= '</a>';
            $mail = $info->mail;
        } else if($action == 'new_password') {
            $mes = $this->GenPassword();
            $subject = 'Восстановление пароля! Apfy.ru';
            $setFormTxt = 'Восстановление пароля! на сайте!';
            $message = 'Новый пароль: '.$mes;
            $mail = $info->mail;
        } else if($action == 'repeat_send') {
            $mes = 'Письмо выслано!';
            $subject = 'Подтверждение регистрации на сайте! Apfy.ru';
            $setFormTxt = 'Подтверждение регистрации на сайте!';
            $message = 'Администрация сайта благодарит Вас за регистрацию и просит пройти по ссылки для подтверждения регистрации.';
            $message .= '<a href="https://apfy.ru/site/confirm?href='.$info["password"].'&m='.$info["mail"].'">';
            $message .= 'https://apfy.ru/site/confirm?href='.$info["password"].'&m='.$info["mail"];
            $message .= '</a>';
            $mail = $info['mail'];
        }
        $mailer = Yii::createObject([
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //'useFileTransport' => true,
            'useFileTransport' => false,
            //вроде работает
            //*
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'ssl://smtp.yandex.com',
                'username' => 'administrator@apfy.ru',
                'password' => 'Ya2yp6Bo6kzPglRekjaj',
                'port' => '465',
                //'encryption' => 'tsl',
            ],
        ]);
        /*
        $mailer = Yii::$app->mailer->setTransport([
            'class' => 'Swift_SmtpTransport',
            'host' => 'ssl://smtp.yandex.com',
            'username' => 'administrator@apfy.ru',
            'password' => 'Ya2yp6Bo6kzPglRekjaj',
            'port' => '465',
        ]);
        /**/
        try{
            if($action == 'repeat_send'){
                $mes = $mailer->compose()
                    ->setFrom('administrator@apfy.ru')
                    ->setTo($mail)
                    ->setBcc(['solin@apfy.ru', 'straengel@gmail.com',])
                    ->setSubject($subject)
                    ->setHtmlBody($message)
                    ->send();
                echo $mes; exit;
            } else {
                $mailer->compose()
                    ->setFrom('administrator@apfy.ru')
                    ->setTo($mail)
                    ->setBcc(['solin@apfy.ru', 'straengel@gmail.com',])
                    ->setSubject($subject)
                    ->setHtmlBody($message)
                    ->send();
            }

        } catch (\Exception $e) {
            echo 'Ошибка в отправке почты!';
        }
        /* backup * /
        try{
            if($action == 'repeat_send'){
                $mes = Yii::$app->mailer->compose()
                    ->setFrom('order@apfy.ru')
                    ->setTo($mail)
                    ->setBcc(['solin@apfy.ru', 'straengel@gmail.com',])
                    ->setSubject($subject)
                    ->setHtmlBody($message)
                    ->send();
                echo $mes; exit;
            } else {
                Yii::$app->mailer->compose()
                    ->setFrom('order@apfy.ru')
                    //->setFrom(['info@apfy.ru'=> 'info'])
                    ->setTo($mail)
                    ->setBcc(['solin@apfy.ru', 'straengel@gmail.com',])
                    ->setSubject($subject)
                    ->setHtmlBody($message)
                    ->send();
            }

        } catch (\Exception $e) {
            echo 'Ошибка в отправке почты!';
        }
        /**/
        return $mes;
    }

    private function GenPassword ($length=10) {
        $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
        $length = intval($length);
        $size=strlen($chars)-1;
        $password = "";
        while($length--) $password.=$chars[rand(0,$size)];
        return $password;
    }
}
