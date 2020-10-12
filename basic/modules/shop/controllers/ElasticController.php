<?php
/**
 * Created by PhpStorm.
 * User: Straengel
 * Date: 07.12.2018
 * Time: 13:41
 */

namespace app\modules\shop\controllers;

use Yii;
use yii\web\Controller;

use app\modules\shop\models\elastic\ElasticProduct;
use yii\web\Response;


class ElasticController extends Controller
{
    public function actionFilters_products(){
        //var_dump(Yii::$app->request->post()); exit;
        if(Yii::$app->request->isAjax){
            $model = $this->generatedParamsArraysProductsInElastic(Yii::$app->request->post());
            //var_dump($model); exit;
            return $this->renderAjax(!empty(Yii::$app->request->post('template')) ? Yii::$app->request->post('template') : 'default', [
                'products' => $model,
            ]);
        } else {
            return $this->goHome();
            //throw new NotFoundHttpException('Страница не найдена.');
        }

    }

    protected function generatedParamsArraysProductsInElastic($data = null){

        $filterArray = [
            [ // логическое и
                'range' => [
                    'price' => [
                        'gte' => (int) $data['minPrice'],
                        'lte' => (int) $data['maxPrice']
                    ],
                ],
            ],
            [ // логическое и
                'bool' => [
                    'should' => [
                        'bool' => [
                            'must' => [
                                'terms' => [  // логическое или
                                    'cats' => [$data['rootCatId']],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
        if(!empty($data['filters']) && is_array($data['filters']) ){
            foreach ($data['filters'] as $k => $v){
                $filterArray[] = [
                    [ // логическое и
                        'bool' => [
                            'should' => [
                                'bool' => [
                                    'must' => [
                                        'terms' => [  // логическое или
                                            'cats' => $v,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ];
            }
        }

        $params = [
            'bool' => [
                'must' => $filterArray
            ],
        ];
        $orderByNew = ['sort' => SORT_ASC, 'quant' => SORT_DESC,  'name' => SORT_ASC, ];
        $model = ElasticProduct::find()->query($params)->limit(300)->all();
        //var_dump($params); exit;
        if($model !== null){
            return $model;
        }
        return false;
    }
}