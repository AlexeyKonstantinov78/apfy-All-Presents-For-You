<?php
namespace app\modules\cabinet\controllers;

use app\models\Users;
use app\modules\cabinet\controllers\DefaultController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\cabinet\models\UserDelivery;

class DeliveryController extends DefaultController
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

    public function actionIndex()
    {
        //var_dump(\Yii::$app->user->id); exit;
        $modelsDelivery = UserDelivery::find()->where(['user_id' => \Yii::$app->user->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $modelsDelivery,
            'sort' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'modelsDelivery' => $modelsDelivery->all(),
        ]);
    }

    public function actionCreate()
    {
        $model = new UserDelivery(['user_id' => \Yii::$app->user->id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }

    }

    public function actionChange($delivery_id){
        if (Yii::$app->request->isAjax && Yii::$app->request->get()) {
            $model = Users::find()->where(['id' => \Yii::$app->user->id])->one();
            $model->delivery_default = $delivery_id;
            \Yii::$app->user->identity->delivery_default = $delivery_id;
            $model->save();
            //var_dump(\Yii::$app->user->identity); exit;
        }
    }

    public function actionDelete(){
        if (Yii::$app->request->isAjax && Yii::$app->request->post('id')) {
            $id = Yii::$app->request->post('id');
            $this->findModel($id)->delete();
            if(\Yii::$app->user->identity->delivery_default == $id){
                $model = Users::find()->where(['id' => \Yii::$app->user->id])->one();
                $model->delivery_default = 0;
                \Yii::$app->user->identity->delivery_default = 0;
                $model->save();
            }
            return 'Адрес удален';
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = UserDelivery::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
