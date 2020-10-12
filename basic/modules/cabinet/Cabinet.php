<?php

namespace app\modules\cabinet;

use Yii;
/**
 * lk module definition class
 */
class Cabinet extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\cabinet\controllers';

    /**
     * @inheritdoc
     */
    public function init() 
    {
        parent::init();
        //$this->layout = 'main';
        /*
        if (!Yii::$app->user->isGuest) {
            if(Yii::$app->user->identity->id == 0 && !empty(\Yii::$app->session['user_id']))
            {
                \Yii::$app->params['user_id'] = \Yii::$app->session['user_id'];
            }
            else
            {
                \Yii::$app->params['user_id'] = Yii::$app->user->identity->id;
            }
        }
        /**/
        // custom initialization code goes here
    }
}
