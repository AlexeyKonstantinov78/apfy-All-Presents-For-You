<?php
namespace app\modules\shop\models\elastic;

use yii\base\Model;
use yii\elasticsearch\ActiveDataProvider;
use yii\elasticsearch\Query;
use yii\elasticsearch\QueryBuilder;
use yii\elasticsearch\ActiveRecord;

class ElasticProduct extends \yii\elasticsearch\ActiveRecord
{
    public static function index() {
        return 'apfy';
    }

    public static function type() {
        return 'ElasticProduct';
    }
    public function rules()
    {
        return [
            [$this->attributes(), 'safe'],
//            [['cats'], 'safe'],
//            [['product_id', 'name'], 'required'],
//            [['name','slug','image'], 'string'],
//            [['product_id','price', 'discount_price', 'sort', 'quant'], 'number'],
        ];
    }

    public function attributes()
    {
        return [
            'name',
            'slug',
            'h1',
            'artid',
            'product_id',
            'price',
            'image',
            'sort',
            'active',
            //'quant',
            'discount_price',
            'cats'
        ];
    }


    /**
     * @return array Сопоставление для этой модели
     */
    public static function mapping()
    {
        return [
            static::type() => [
                'properties' => [
                    'name' => ['type' => 'string'],
                    'artid' => ['type' => 'string'],
                    'slug' => ['type' => 'string'],
                    'product_id' => ['type' => 'integer'],
                    'price' => ['type' => 'float'],
                    'discount_price' => ['type' => 'float'],
                    'image' => ['type' => 'string'],
                    'sort' => ['type' => 'integer'],
                    'active' => ['type' => 'integer'],
                    //'quant' => ['type' => 'integer'],
                    'cats' =>  ['type' => 'integer']
                ]
            ],
        ];
    }

	
	public static function createIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->createIndex(static::index(), [
            //'settings' => [ /* ... * / ],
            'mappings' => static::mapping(),
            //'warmers' => [ /* ... * / ],
            //'aliases' => [ /* ... * / ],
            //'creation_date' => '...'
        ]);
    }
    /**
     * Установка (update) для этой модели
     * /
    public static function updateMapping()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->setMapping(static::index(), static::type(), static::mapping());
    }

    /**
     * Создать индекс этой модели
     * /
    public static function createIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->createIndex(static::index(), [
            'settings' => [ /* ... * / ],
            'mappings' => static::mapping(),
            //'warmers' => [ /* ... * / ],
            //'aliases' => [ /* ... * / ],
            //'creation_date' => '...'
        ]);
    }

    /**
     * Удалить индекс этой модели
     */
    public static function deleteIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->deleteIndex(static::type());
    }
    /**
     * Удалить индекс этой модели
     */
    public static function deleteIndexAll()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->deleteIndex(static::type());
    }
    /**/
}