<?php

namespace app\modules\shop\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\base\DynamicModel;
use yii\base\Exception;
use app\modules\shop\models\Product;
use app\modules\shop\models\Order;
use app\modules\shop\models\OrderItem;
use app\modules\shop\models\Cart;
use app\modules\shop\models\CdekCity;
use app\modules\shop\models\Invoice;
use yii\helpers\Json;

/**
 * ProductController implements the CRUD actions for Product model.  118, 181, 332
 */
class CartController extends Controller
{

    public function beforeAction($action)
    {
        //TODO выключить для экшен лист
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    //TO DO to look
    public function actionResult($id = null, $param = null, $ok = null, $message = null){
        if($id==null && $param !== sha1('dsafgaSDsr@43wsdf'.$id.'dsafgaSDsr@43wsdf')) return $this->goHome();
            return $this->render('success', [
                'id' => $id,
                'message' => $message,
                'ok' => $ok
            ]);
    }

    public function actionList()
    {

        $this->view->title = 'Оформление заказа';

        $order = new Order(['date_create' => date('Y-m-d H:i:s'), 'date_edit' => date('Y-m-d H:i:s'), 'delivery' => 0,]);
        $p = Cart::getProductList();


        if ($order->load(Yii::$app->request->post()) && !empty($p)) {
            $order->save();

            $cart = Cart::getCart();
            $sum = 0;
            foreach($p as $pr){
                if(!empty($pr->discount_price) && $pr->discount_price>0) $pr->price = $pr->discount_price;
                $OrderItem = new OrderItem();
                $OrderItem->item_price = $pr->price;
                $OrderItem->order_id = $order->id;
                $OrderItem->product_id = $pr->id;
                $sum += $OrderItem->sum = $cart[$pr->id]['quantity'] * $pr->price;
                $OrderItem->save();
            }
            $id = $order->id;
            if($sum > 0) {
                $order->total = $sum;
                $order->save();
                self::send_mail($order->id, ['order@apfy.ru', $order->email]);

            }


            //перенаправления на АльфаБанк
            if($order->payment_choose == 2){
                //$remoteId Идентификатор заказа из api
                //Cart::flushList();
                $data = [
                    'orderNumber' => $order->id,
                    'orderId' => $order->id,
                    'amount' => ($order->delivery_price+$order->total)*100,
                    'returnUrl' => 'https://apfy.ru/shop/cart/banksuccess',
                    'failUrl' => 'https://apfy.ru/shop/cart/banksuccess',
                    'sessionsTimeoutSecs' => 1200,
                    'description' => 'Заказ в магазине https://apfy.ru',

                ];

                $result = $this->sendApiAlfa('registerPreAuth.do', $data);
                if(array_key_exists('formUrl', $result)) {

                    $formUrl = $result['formUrl'];
                    $invoice = new Invoice([
                        'order_id' => $order->id,
                        'sum' => $order->total,
                        'remote_id' => $result['orderId'],
                        'pay_time' => date('Y-m-d H:i:s'),
                        'status' => 2,
                        'method' => 'AlfaBank',
                    ]);
                    $invoice->save(false);
                    return $this->redirect($formUrl);
                }

            }
            return $this->redirect(['/shop/cart/result','id' => $id, 'param' => sha1('dsafgaSDsr@43wsdf'.$id.'dsafgaSDsr@43wsdf')]);
        }
        return $this->render('listnew', [
            'model' => Cart::getProductList(),
            'cart' => Cart::getList(),
            'order' => $order,
            //'formCdek' => $formCdek,
            //'formApfy' => $formApfy,
        ]);
    }

    //работа с АльфаБанк
    private function sendApiAlfa($action, $data)
    {

        //тестовые данные
//        $data['userName'] = 'apfy-api';
//        $data['password'] = 'apfy*?1'; //тестовые доступы
//        $url = 'https://web.rbsuat.com/ab/rest/' . $action; //тестовый
        $data['userName'] = 'apfy-api';
        $data['password'] = 'fLdLI2Ypti8u4BzAs8TR?'; //Боевые
        $url = 'https://pay.alfabank.ru/payment/rest/' . $action;//боевой сервер

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        $out = curl_exec($curl);
        curl_close($curl);
        return Json::decode($out);
    }


    //работа со сбером
    private function sendApi($action, $data)
    {

        //тестовые данные

        $data['userName'] = 'apfy-api';
        $data['password'] = 'Qt2RjgRAhP8s7drOh2go!'; //тестовые доступы
        //$data['password'] = 'XhGleHy9RbnZGu6DI8qE*'; //боевой доступ
        $url = 'https://securepayments.sberbank.ru/payment/rest/' . $action; //не тестовый
        //$url = 'https://3dsec.sberbank.ru/payment/rest/' . $action;//тестовый сервер


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        $out = curl_exec($curl);
        curl_close($curl);
        return Json::decode($out);
    }

    //TODO tolook
    public function actionSbersucces(){

        $findInvoice = $this->findInvoice(Yii::$app->request->get('orderId'));
        $r = $this->sendApi('getOrderStatusExtended.do',['orderId' => Yii::$app->request->get('orderId')]);

        $findInvoice->message = $r['errorMessage'];
        $findInvoice->status = $r['errorCode'];
        $findInvoice->update();
        return $this->redirect(['/shop/cart/result','id' => $findInvoice->order_id, 'param' => sha1('dsafgaSDsr@43wsdf'.$findInvoice->order_id.'dsafgaSDsr@43wsdf'), 'ok' => 1]);
        /*return $this->render('resultinvoice', [
            'model' => $findInvoice
        ]);*/
    }
    //TODO tolook
    public function actionBanksuccess(){

        $findInvoice = $this->findInvoice(Yii::$app->request->get('orderId'));
        $r = $this->sendApiAlfa('getOrderStatusExtended.do',['orderId' => Yii::$app->request->get('orderId')]);

        $findInvoice->message = $r['actionCodeDescription'];
        $findInvoice->status = $r['orderStatus'];
        $findInvoice->update();
        return $this->redirect([
            '/shop/cart/result',
            'id' => $findInvoice->order_id,
            'param' => sha1('dsafgaSDsr@43wsdf'.$findInvoice->order_id.'dsafgaSDsr@43wsdf'),
            'ok' => $r['orderStatus'],
            'message' => $r['actionCodeDescription'],
        ]);
        /*return $this->render('resultinvoice', [
            'model' => $findInvoice
        ]);*/
    }

    //TODO tolook
    public function actionSuccess(){

        $findInvoice = $this->findInvoice(Yii::$app->request->get('orderId'));
        $r = $this->sendApi('getOrderStatusExtended.do',['orderId' => Yii::$app->request->get('orderId')]);

        $findInvoice->message = $r['errorMessage'];
        $findInvoice->status = $r['errorCode'];
        $findInvoice->update();
        return $this->render('result', [
            'model' => $findInvoice
        ]);
    }

    private function findInvoice($id){
        if (($model = Invoice::findOne(['remote_id' =>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //public function actionSendFastOrder(){
    public function actionSendfastorder(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(Yii::$app->request->isAjax && Yii::$app->request->post()) {
            $product = Product::findOne(['id' => Yii::$app->request->post('id')]);

            $message['errors']='Ошибка, просьба обратиться к администрации сайта';
            if( $product == null) throw new NotFoundHttpException('Нет такого товара');
            $order = new Order([
                'date_create' => date('Y-m-d H:i:s'),
                'date_edit' => date('Y-m-d H:i:s'),
                'name' => 'Клиент в один клик',
                'email' => 'oneclick@oneclick.ru',
                'town' => 'Один клик',
                'street' => 'Один клик',
                'delivery' => '0',
                'delivery_choose' => 'Один клик',
                'house' => 'Один клик',
                'apartment' => 'Один клик',
                'payment_choose' => '0',
            ]);
            if(Yii::$app->request->post()['Order']['terms_of_use'] == 1){
                if($order->load(Yii::$app->request->post())) {

                    $order->save();
                    if ($order->validate()) {
                        $OrderItem = new OrderItem();
                        if(!empty($product->discount_price) && $product->discount_price>0) $product->price = $product->discount_price;
                        $OrderItem->item_price = $product->price;
                        $OrderItem->order_id = $order->id;
                        $OrderItem->product_id = $product->id;
                        $order->total = $product->price;
                        $order->save();
                        $OrderItem->save();
                        $message['errors'] = false;
                        $message['status'] = 'В ближайшее время с Вами свяжется менеджер. Номер Вашего заказа - '.$order->id;
                        self::send_mail($order->id);
                    } else {
                        // данные не корректны: $errors - массив содержащий сообщения об ошибках
                         $message = 'Необходима необходимо заполнить телефон!';
                    }

                }
            } else {
                $message = 'Необходима согласиться с пользовательским соглашением!';
            }


            return $message;
        }
    }
    //public function actionSendFastOrder(){
    public function actionSendunderorder(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(Yii::$app->request->isAjax && Yii::$app->request->post()) {
            $product = Product::findOne(['id' => Yii::$app->request->post('id')]);

            $message['errors']='Ошибка, просьба обратиться к администрации сайта';
            if( $product == null) throw new NotFoundHttpException('Нет такого товара');
            $order = new Order([
                'date_create' => date('Y-m-d H:i:s'),
                'date_edit' => date('Y-m-d H:i:s'),
                'name' => 'Клиент под заказ!',
                'email' => 'oneclick@oneclick.ru',
                'town' => 'Под заказ!',
                'street' => 'Под заказ!',
                'delivery' => '0',
                'delivery_choose' => 'Под заказ!',
                'house' => 'Под заказ!',
                'apartment' => 'Под заказ!',
                'payment_choose' => '0',
            ]);
            if(Yii::$app->request->post()['Order']['terms_of_use'] == 1){
                if($order->load(Yii::$app->request->post())) {

                    $order->save();
                    if ($order->validate()) {
                        $OrderItem = new OrderItem();
                        if(!empty($product->discount_price) && $product->discount_price>0) $product->price = $product->discount_price;
                        $OrderItem->item_price = $product->price;
                        $OrderItem->order_id = $order->id;
                        $OrderItem->product_id = $product->id;
                        $order->total = $product->price;
                        $order->save();
                        $OrderItem->save();
                        $message['errors'] = false;
                        $message['status'] = 'В ближайшее время с Вами свяжется менеджер. Номер Вашего заказа - '.$order->id;
                        self::send_mail($order->id);
                    } else {
                        // данные не корректны: $errors - массив содержащий сообщения об ошибках
                        return $message['errors'] = $order->errors;
                    }

                }
            } else {
                $message = 'Необходима согласиться с пользовательским соглашением!';
            }


            return $message;
        }
    }

    public function actionCheckout()
    {
        return $this->render('checkout', [
            'model' => Cart::getProductList(),
        ]);
    }

    public function actionAdd()
    {
        return $this->response(Yii::$app->request->post(), 'add');
    }

    public function actionRemove()
    {
        return $this->response(Yii::$app->request->post(), 'remove');
    }

    public function actionFlush()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        Cart::flushList();
        return true;
    }

    public function actionDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $getCart = Cart::getCart();
        $id = Yii::$app->request->post('id');
        $quantity = !isset($getCart[$id]) ? null : $getCart[$id]['quantity'];
        if($quantity == null) throw new NotFoundHttpException('The requested page does not exist.');
        $quantity--;
        return $this->response(['id' => $id, 'quantity' => $quantity < 1 ? 1 : $quantity], 'setQuantity');

    }

    public function actionAjaxcity(){
        if(Yii::$app->request->isAjax && Yii::$app->request->get()){

            $city = CdekCity::findOne(['id' => (int)Yii::$app->request->get('id')]);
//            echo Yii::$app->request->get('id');
//            var_dump($city);
//            exit;
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($city !== null)
                return $city->cityName;
        }
    }

    protected function response($id, $action)
    {
        $quantity = null;
        if(isset($id['quantity'])) $quantity = (int) $id['quantity'];
        if(isset($id['thumb'])) $thumb = (int) $id['thumb'];
        if(isset($id['id'])) $id = $id['id']; else $id = 0;

        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($id)) {
            $model = Product::find()->where(['id' => $id])->one();
            if($model == null) throw new NotFoundHttpException('The requested page does not exist.');

            switch ($action)
            {
                case 'remove':
                    Cart::removeProduct($model);
                    break;

                case 'add':
                    Cart::addProduct($model, $quantity);
                    break;

                case 'setQuantity':
                    $q = isset($quantity) ? $quantity : 0;

                    Cart::setQuantityProduct($model, $q);
                    break;

            }
            $getCart = Cart::getCart();
            return [
                'name'=>!empty($model->seoTags->h1) ? $model->seoTags->h1 : $model->name,
                'price'=>number_format($model->price,0,'',' '),
                'id'=>$model->id,
                'href'=>'/product/'.$model->seoTags->slug,
                'image'=>(isset($thumb) ? $model->mainimage->thumb(($thumb < 50 || $thumb > 500 ? 300 : $thumb)) : $model->mainimage->image),
                'total'=>number_format(Cart::getTotalPrice(),0,'',' '),
                'count'=> Cart::getCount() ,
                'quantity'=> !isset($getCart[$model->id]) ? null : $getCart[$model->id]['quantity']
            ];
//                return ['name'=>$model->name, 'price'=>$model->price, 'id'=>$model->id, 'image'=>(isset($thumb) ? $model->mainimage->thumb(($thumb < 50 || $thumb > 500 ? 300 : $thumb)) : $model->mainimage->image), 'total'=>Cart::getTotalPrice(),
//                    'count'=> Cart::getCount() ,
//                    'quantity'=> Cart::getCart()[$model->id]['quantity']
//                ];
        }

        return false;

    }
    //to look
    protected function send_mail($order_id, $setting_mail=['order@apfy.ru']){
        $order = Order::find()->where(['id' => $order_id])->one();

        if($order == null) return false;

        $message = '<b>Спасибо за заказ!</b><br/>';
        $message .= '<b>В ближайшее время с Вами свяжется менеджер для подтверждения заказа</b>.<br/><br/><br/>';
        $message .= '<b>Детали:</b><br/>';
        $message .= 'Номер заказа: '.$order->id.'<br/>';
        $message .= 'От: '.$order->name.'<br/>';
        $message .= 'Телефон: '.$order->phone.'<br/>';
        if(!empty($order->email))
            $message .= 'E-mail: '.$order->email.'<br/>';
        $message .= 'Адрес: '.$order->town.', '.$order->street;
        if(!empty($order->house))
            $message .=', Дом'.$order->house;
        if(!empty($order->corps))
            $message .=', Корпус'.$order->corps;
        if(!empty($order->entrance))
            $message .=', Подъезд'.$order->entrance;
        if(!empty($order->floor))
            $message .=', Этаж'.$order->floor;
        if(!empty($order->apartment))
            $message .=', кв.'.$order->apartment;
        $message .='<br/>';
        $message .= 'Доставка: '.$order->getNameDelivery($order->delivery).'<br/>';
        //tolook and todo
        if($order->delivery != 0){
            if($order->delivery_choose == 0)
                $message .= 'Способ доставки: '.$order->getNameDeliveryCh(0).'<br/>';
            else
                $message .= 'Способ доставки: '.$order->getNameDeliveryCh($order->delivery_choose).'<br/>';
        }
        $message .= 'Способ оплаты: '.$order->getNamePayment($order->payment_choose).'<br/>';

        $message .= '<b>Стоимость доставки: <i>'.$order->delivery_price.'</i></b><br/>';
        $message .= '<b>Стоимость товара: <i>'.$order->total.'</i><br/>';
        $message .= '<b>Итоговая цена: <i>'.((float)$order->total+(float)$order->delivery_price).'</i><br/>';
        //$message .= '<b>Время заказа: <i>'.$order->date_create.'</i></b><br/>';
        if(!empty($order->comment_more)) {
            $message .= '<b>Комментарии к заказу (если есть):</b><br/>'.$order->comment_more;
        }


        $message .= '<table with="100%" border="1">
		<tr>
		<td>Фото</td>
		<td>Название</td>
		<td>Цена</td>
		<td>Количество</td>
		<td>Сумма</td>
		</tr>';
        foreach($order->products as $product)
        {
            if(!empty($product->product->seo->h1)) $product->product->name = $product->product->seo->h1;
            $message .= '<tr>';
            $message .= '<td><img src="'.$_SERVER['HTTP_HOST'].'/'.str_replace(" ","%20",$product->product->imagess->thumb(300)).'"/></td>';
            $message .= '<td><a href="http://'.$_SERVER['HTTP_HOST'].'/product/'.$product->product->seo->slug.'">'.$product->product->name.'</a></td>';
            $message .= '<td>'.$product->item_price.'</td>';
            $message .= '<td>'.($product->sum/$product->item_price).'</td>';
            $message .= '<td>'.$product->sum.'</td>';
            $message .= '</tr>';
        }
        $message .= '</table>';
        $message .= '<br/><br/>Письмо сформировано автоматически. Пожалуйста, не отвечайте на него.<br/> 
        По всем вопросам Вы можете обращаться по контактам, указанным ниже:<br/><br/><br/>
        All Presents For You<br/>
        Все подарки для Вас<br/> 
        <a href="https://apfy.ru">https://apfy.ru</a><br/>
        <a href="tel:+7 495 199 18 25">+7 495 199 18 25</a><br/>
        <a href="mail:info@apfy.ru">info@apfy.ru</a>';
        //$mail = ;

        try{
            Yii::$app->mailer->compose()
                ->setFrom('order@apfy.ru')
                ->setTo($setting_mail)
                ->setBcc(['solin@apfy.ru', 'straengel@gmail.com'])
                ->setSubject('Заказ на APFY.RU!')
                ->setHtmlBody($message)
                ->send();
        } catch (\Exception $e) {

        }
        return true;
    }



}

