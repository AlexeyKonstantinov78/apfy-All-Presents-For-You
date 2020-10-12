<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 23.05.2018
 * Time: 11:11
 */
namespace app\modules\root\controllers;

use Yii;
use app\models\Pvz;
use app\modules\root\models\OcCdekpvz;
use app\modules\root\controllers\DefaultController;
use yii\web\UploadedFile;

class ExcelController extends DefaultController
{
    public function actionImportpvz()
    {
        $model = new \yii\base\DynamicModel([
            'import'
        ]);
        $model->addRule(['import'], 'file', ['skipOnEmpty' => false]);
        $result = array();
        if (Yii::$app->request->isPost) {
            $model->import = UploadedFile::getInstance($model, 'import');

            $data = \moonland\phpexcel\Excel::import($model->import->tempName, [
                'setFirstRecordAsKeys' => false, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
                'setIndexSheetByName' => false, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
                'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
            ]);
            //$find = new Pvz();
            //$find = new OcCdekpvz();
            //$find->deleteAll();
            foreach ($data as $col){
                $find = new OcCdekpvz();
                $find->code = $col['A'];
                $find->country = $col['B'];
                $find->region = $col['C'];
                $find->town = $col['D'];
                $find->name = $col['E'];
                $find->phone = $col['F'];
                $find->work_time = $col['G'];
                $find->full_address = $col['H'];
                $find->address = $col['I'];
                $find->save(false);
//                var_dump($col);
//                exit;
                /*$find = new Pvz();
                $find->country = $col['A'];
                $find->region = $col['B'];
                $find->town = $col['C'];
                $find->name = $col['D'];
                $find->street = $col['E'];
                $find->house = $col['F'];
                $find->office = $col['G'];
                $find->comments = $col['H'];
                $find->station = $col['I'];
                $find->halt = $col['J'];
                $find->phone = $col['K'];
                $find->clock = $col['L'];
                $find->save(false);*/
            }

            return $this->render('importpvz', ['model' => $model, 'result' => $result]);
        }
        return $this->render('importpvz', ['model' => $model, 'result' => $result]);
    }
}