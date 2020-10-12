<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 01.12.2016
 * Time: 3:59
 */
namespace app\modules\root\controllers\shop;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use app\modules\shop\models\Category;
use app\modules\root\controllers\DefaultController;
use app\modules\shop\models\Filtres;

class CategoryController extends DefaultController
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Category();
        $tree = $model->generateTreeJs();
        return $this->render('index', [
            'model' => $model,
            'tree' => $tree,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if(isset(Yii::$app->request->post()['ft_2'])){
                Filtres::setFiltresCategories(Yii::$app->request->get('id'), Yii::$app->request->post()['ft_2']);
            }
            if($model->save() && isset(Yii::$app->request->post()['submit-button'])) {
                return $this->redirect('/root/shop/category');
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }
        $category = new Category();

        $tree = $category->generateTreeEditCat();
        unset($tree[$model->id]);
        //фильтры TODO
        $ids = Filtres::getCategoriesIds($model->id);
        $ids = ArrayHelper::getColumn($ids, 'id_category');
        $options = [];
        if(!empty($ids)){
            foreach($ids as $v)
                $options[$v] = ['selected'=>true];
        }

        $treeFiltres = $category->generateTreeJs($options,'350');

        return $this->renderAjax('_form', [
            'model' => $model,
            'rootUrl' => $this->rootUrl($model),
            'tree' => $tree,
            'treeFiltres' => $treeFiltres
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category(['active'=>'1']);
        //var_dump($model);
        //exit;
        $options = [];
        if ($model->load(Yii::$app->request->post()) && $model->makeRoot()->save()) {
            $model = new Category();

            $tree = $model->generateTreeJs();
            return $this->render('index', [
                'model' => $model,
                'tree' => $tree,
            ]);
        } else {
            $tree = $model->generateTreeEditCat();
            $treeFiltres = $model->generateTreeJs($options,'350');
            return $this->render('create', [
                'model' => $model,
                'rootUrl' => $this->rootUrl($model),
                'tree' => $tree,
                'treeFiltres' => $treeFiltres,
            ]);
        }
    }

    public function actionAddchild()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) {
            $model = new Category();
            $post = Yii::$app->request->post();
            $parent = $this->findModel($post['parent_id']);
            if($parent != null)
            {
                $model->name = $post['name'];
                $model->parent_id = $post['parent_id'];
                $model->appendTo($parent)->save();
            }
            return $model;
        }
    }

    public function actionSort()
    {
        if(Yii::$app->request->isAjax){

            $p = Yii::$app->request->post();
            $model1 = $this->findModel($p['first_id']);
            $model2 = $this->findModel($p['second_id']);
            //$model1->parent_id = $model2->parent_id;
            if($p['act'] == 'after') {
                $model1->moveAfter($model2)->save();
            } else {
                $model1->moveBefore($model2)->save();
            }
            return 'eys';
        }
        return 'net';
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->post()['id'];
        $this->findModel($id)->deleteWithChildren();
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['message'=>true];
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::find()->where(['id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function rootUrl($model){
        //$rootUrl = $model->seoTags->slug;

        $rootUrl = '';
        if($rootUrl == ''){
            if($model->parent !== null){
                $rootUrl .= $model->parent->seoTags->slug . '-';
            }
        }
        /* testing
        var_dump($model->parent);
        exit;
        //*/
        return $rootUrl;
    }
}
