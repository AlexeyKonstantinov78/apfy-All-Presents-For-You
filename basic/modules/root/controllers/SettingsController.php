<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 20.07.2018
 * Time: 15:38
 */
namespace app\modules\root\controllers;

use Yii;
use app\modules\root\controllers\DefaultController;
use app\modules\shop\models\Product;
use app\modules\shop\models\ProductInCategory;
use yii\db\Command;
use yii\httpclient\XmlParser;
use yii\httpclient\Client;

class SettingsController extends DefaultController {

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDiscountitem(){
        $products = Product::find()->where('discount_price>0')->asArray()->column();
        $arr = array();
        foreach ($products as $k=>$v){
            $arr[] = [
                'id_product' => $v,
                'id_category' => 1146
            ];

        }
        ProductInCategory::deleteAll(['id_category' => 1146]);
        $columnNameArray = ['id_product','id_category'];
        Yii::$app->db->createCommand()
            ->batchInsert(
                'product_in_category', $columnNameArray, $arr
            )->execute();

        return $this->render('index');
    }

    public function actionTigernu(){
        $client = new Client(['baseUrl' => 'http://files.digit-style.ru/files/xml_files/goods_bp_okp.yml']);
        $d = file_get_contents('http://files.digit-style.ru/files/xml_files/goods_bp_okp.yml');
        $XML = new XmlParser;
        //$XML->parse($d, );
        $response = $client->createRequest()
            ->setFormat(Client::FORMAT_XML)
            ->setUrl('http://files.digit-style.ru/files/xml_files/goods_bp_okp.yml')
            ->send();

        $xmlArray = $XML->parse($response);
        $i = 0;
        foreach ($xmlArray['shop']['offers']['offer'] as $k=>$v){
            //var_dump($v['barcode']);
            //var_dump($v['ostatok']);
            //var_dump($v);
            //exit;
            if(empty($v['barcode'])) Continue;
            $product = Product::find()->where(['gtin' => $v['barcode']])->one();
            if($product !==null){
				//if(isset($v['ostatok']) && empty($v['ostatok'])) Continue;
                if($v['ostatok'] == 0)
                    $v['ostatok'] = 2;
				else
					$v['ostatok'] = 1;
                if($product->active !== $v['ostatok']){
                    $product->active = $v['ostatok'];
                    $product->save();
                }
            }
        }
        return $this->render('index');
    }
}