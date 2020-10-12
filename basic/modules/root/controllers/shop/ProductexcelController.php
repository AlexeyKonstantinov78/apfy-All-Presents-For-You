<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 31.01.2018
 * Time: 13:15
 */
namespace app\modules\root\controllers\shop;

use app\modules\shop\models\Category;
use Yii;
use app\modules\root\controllers\DefaultController;
use app\modules\shop\models\Product;
use yii\web\UploadedFile;

class ProductexcelController extends DefaultController {
    public function actionExport()
    {
        $model = Product::find()->with(['categories'])->all();
//        var_dump($model[0]->getBrandProduct());
//        exit;
        return $this->render('export', ['model' => $model]);
    }

    public function actionImport()
    {
        $model = new \yii\base\DynamicModel([
            'import'
        ]);
        $model->addRule(['import'], 'file', ['skipOnEmpty' => false]);
        $result = array();
        if (Yii::$app->request->isPost) {
            $model->import = UploadedFile::getInstance($model, 'import');

            $data = \moonland\phpexcel\Excel::import($model->import->tempName, [
                'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
                'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
                'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
            ]);
            foreach ($data as $col){


                if(array_key_exists('id', $col) && Product::find()->where(['id' => $col['id']])->one() !== null){
                    $find = Product::find()->where(['id' => $col['id']])->one();
                    //if($find->weight != $col['weight'] ||  $find->scope != $col['scope'] ){
                    //заказа gtin
//                    if(isset($col['gtin'])){
//                        $find->gtin = (string)$col['gtin'];
//                        $result[] = [
//                            'id' => $find->id,
//                            'artid' => $find->artid,
//                            'gtin' => $find->gtin,
//                            'name' => $find->name,
//                            'weight' => $find->weight,
//                            'scope' => $find->scope,
//                            'discount_price' => $find->discount_price,
//                        ];
//
//                        $find->save();
//                    }

                    if($find->price != $col['price'] ||  $find->active != $col['active'] || $find->discount_price != $col['discount_price']){
//
						$find->discount_price = ceil($col['discount_price']);
                        $find->active = (int)$col['active'];
                        $find->price = ceil($col['price']);
                        if($find->active>0){
                            $find->date = date('Y-m-d H:i:s');
                        }
                        //if(isset($col['gtin']) && $find->gtin != $col['gtin']) $find->gtin = $col['gtin'];
//                        $find->weight = (float)$col['weight'];
//                        $find->scope = (float)$col['scope'];
                        $result[] = [
                            'id' => $find->id,
                            'artid' => $find->artid,
                            'gtin' => $find->gtin,
                            'name' => $find->name,
                            'weight' => $find->weight,
                            'scope' => $find->scope,
                            'discount_price' => $find->discount_price,
                        ];

                        $find->save();
                    }
                }
            }

            //$result = array();
            return $this->render('import', ['model' => $model, 'result' => $result]);
        }
        return $this->render('import', ['model' => $model, 'result' => $result]);
    }

    public function actionExportproduct()
    {
        /*
        $model = new \yii\base\DynamicModel([
            'import'
        ]);
        $model->addRule(['import'], 'categeory_id', ['skipOnEmpty' => false]);
        /**/
        $category = new Category();
        $allCats = $category->generateTreeEditCat();
        $model = new \yii\base\DynamicModel([
            'category_id'
        ]);
        $model->addRule(['category_id'], 'number');
        if (Yii::$app->request->isPost) {
            $model = Product::find()->joinWith(['category'])->where(['id_category'=>Yii::$app->request->post('DynamicModel')['category_id']])->all();
            //var_dump($model[0]->mainImage->image); exit;
            return $this->render('exportSeoImg', ['model' => $model]);
        }
        return $this->render('exportproduct',[
            'allCats' => $allCats,
            'model' => $model
        ]);
    }
}