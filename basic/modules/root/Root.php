<?php

namespace app\modules\root;
use Yii;
/**
 * root module definition class
 */
class Root extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\root\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        //var_dump($this->layout);
        //*exit();
//        if(YII_DEBUG) {
//            var_dump(Yii::$app->user->identity);
//            exit;
//        }
        if (Yii::$app->user->isGuest) {
            $this->layout = 'login';
        } else {
            $this->layout = 'root';
        }

        //Yii::$app->controller->layout = 'root';
        // custom initialization code goes here
    }
}
