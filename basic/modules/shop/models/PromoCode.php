<?php
namespace app\modules\shop\models;

class PromoCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    //public $seo;
    //public $images;

    public static function tableName()
    {
        return 'promo_code';
    }

    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        //картинки будут браться из картинок и необязательные
        return [
            'id' => 'id',
            'name' => 'Название',
            'description' => 'Описание', //необязательное
            'cost_percent' => 'Проценты или рубли', //что будет вычитаться в корзине при применении промокода
            'discount' => 'Скидка', //Единица скидки в при применении промокода
            'user_reach' => 'Пользовательский охват', //Все ли пользователи будут участвовать в акции или нет int 2
            'active' => 'Активна', //Действует ли акиция или нет
            'period_action' => 'Действие акции', //Действует в течении периода или одноразовая или количественная или то и то сразу
            'quant' => 'Количество акций', //при нуле будет действовать безгранична или наче ограничено
            'date_end' => 'Дата конца', //Дата конца акции
            'date_last' => 'Дата активации', //Когда последний раз действовала акция
        ];
    }
}
