<?php

namespace app\modules\cabinet\controllers;

use app\modules\shop\models\Order;
use Yii;
use app\modules\cabinet\controllers\DefaultController;
use app\modules\cabinet\models\WishList;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WishlistController implements the CRUD actions for WishList model.
 */
class OrderhistoryController extends DefaultController
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all WishList models.
     * @return mixed
     */
    public function actionIndex()
    {

        /*var_dump(\Yii::$app->user->identity->mail);
        exit;*/
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->where(['email'=>\Yii::$app->user->identity->mail])->orderBy([
                'date_create' => SORT_DESC,
                'id' => SORT_DESC,
            ]),
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 10,
            ],
            'sort'=> false
        ]);
        //var_dump(Order::find()->where(['email'=>\Yii::$app->user->identity->mail])->asArray()->all()); exit;
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            //'model' => Order::find()->asArray()->all()
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Order::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
