<?php

namespace app\modules\shop\models;

use Yii;
use app\modules\shop\models\Product;
use app\models\Images;
use yii\web\Session;


class Cart extends \yii\base\Model
{


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','price','quantity'], 'required'],
            //    [['price', 'discount_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Цена',
            'quantity' => 'Кол-во',
        ];
    }


    public static function addProduct($model, $quant=null)
    {
        $cart = self::getCart();
        if($cart == 0) $cart = [];
        if(!empty($model->discount_price) && $model->discount_price>0) $model->price = $model->discount_price;
        if(isset($cart[$model->id])) $cart[$model->id]['quantity']++;
        else $cart[$model->id] = ['id'=>$model->id, 'price'=>$model->price, 'quantity' => 1];
        if($quant != null) $cart[$model->id]['quantity'] = abs(intval($quant));
        Yii::$app->session['_Cart'] = $cart;
    }

    public static function setQuantityProduct($model, $q)
    {
        $q = abs($q);
        if($q > 99) $q = 99;

        if(($cart = self::getCart()) == 0) return 0;

        if(isset($cart[$model->id]))
        {
            if($q == 0)
            {
                unset($cart[$model->id]);
            }
            else
                $cart[$model->id]['quantity'] = $q;
        }
        Yii::$app->session['_Cart'] = $cart;
    }

    public static function removeProduct($model)
    {
        if(($cart = self::getCart()) == 0) return 0;

        if(isset($cart[$model->id]))
        {
            unset($cart[$model->id]);
        }

        Yii::$app->session['_Cart'] = $cart;
    }

    public static function flushList()
    {
        Yii::$app->session['_Cart'] = [];
    }

    public static function getProductlist()
    {
        if(($cart = self::getCart()) == 0) return null;

        $ids = array_keys($cart);
        return Product::find()->where(['id'=>$ids])->all();
    }

    public static function getList()
    {
        return $cart = Yii::$app->session['_Cart'];
    }

    public static function getTotalPrice()
    {
        if(($cart = self::getCart()) == 0) return 0;
        $models = self::getProductlist();
        $sum = 0;
        foreach($models as $p)
        {
            if(!empty($p->discount_price) && $p->discount_price>0) $p->price = $p->discount_price;
            $sum += $cart[$p->id]['quantity'] * $p->price;
        }

        return $sum;
    }

    public static function getCount()
    {

        $cart = Yii::$app->session['_Cart'];
        /*$total = 0;
        if($cart == null) return 0;
        foreach($cart as $id=>$c)
        {
            $total += $cart[$id]['quantity'];
        }*/

        return count($cart);
    }

    public static function getCart()
    {
        $cart = Yii::$app->session['_Cart'];
        if($cart == null) return 0;

        return $cart;
    }

}
