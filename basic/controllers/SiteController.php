<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Page;
use app\models\Users;
//на время
use app\modules\shop\models\ProductInCategory;

class SiteController extends Controller
{
    public function init()
    {
        parent::init();
        $this->layout = 'main';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
			'model' => $this->findModelPage(''),
		]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
	protected function findModelPage($slug)
    {
        if (($model = Page::findSlug($slug)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionConfirm(){
        $model = Users::find()->where(['mail' => Yii::$app->request->get('m'), 'password' => Yii::$app->request->get('href')])->one();
        if ($model !== null) {
            $title = 'Произошла ошибка';
            $message = 'Произошла ошибка во время регистрации пожалйусто обратиться к Администрации';
            if(Yii::$app->request->get('m')){
                if ($model->status == 1) return $this->goHome();
                $model->status = 1;
                $model->save();
                $title = 'Подтверждение о регистрации';
                $message = 'Вы успешно прошли регистрацию';
            } else if(Yii::$app->request->get('reset')){
                    $title = 'Сброс пароля!';
                    $message = 'Успешно сбросили пароль!';
            }
            return $this->render('confirm', [
                'header' => $title,
                'message' => $message
            ]);
        }

        return $this->goHome();
    }

}



/**
 * Displays contact page.
 *
 * @return string
 */
/*
public function actionContact()
{
    $model = new ContactForm();
    if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
        Yii::$app->session->setFlash('contactFormSubmitted');

        return $this->refresh();
    }
    return $this->render('contact', [
        'model' => $model,
        'page_contacts' => $this->findModelPage('contacts'),
    ]);
}
//*/

//    public function actionContacts()
//    {
//        $model = new ContactForm();
//        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
//            Yii::$app->session->setFlash('contactFormSubmitted');
//
//            return $this->refresh();
//        }
//        return $this->render('contact', [
//            'model' => $model,
//            'page_contacts' => $this->findModelPage('contacts'),
//        ]);
//    }