<?php
namespace app\modules\shop\models\elastic;

class ElasticCategory  extends \yii\elasticsearch\ActiveRecord
{
    public static function index() {
        return 'category';
    }

    public static function type() {
        return 'ElasticCategory';
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
            'category_id',
            'parent_id',
            'filter_category_id',
            'seo_title',
            'seo_description',
            'seo_keywords',
            'name',
            'slug',
            'description',
            'image',
            'sort',
            'active',
            'is_brand',
            'product_quant',
            'max',
            'min',
            'tpl'
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
                    'category_id' => ['type' => 'integer'],
                    'parent_id' => ['type' => 'integer'],
                    'filter_category_id' => ['type' => 'long'],
                    'seo_title' => ['type' => 'string'],
                    'seo_description' => ['type' => 'string'],
                    'seo_keywords' => ['type' => 'string'],
                    'name' => ['type' => 'string'],
                    'slug' => ['type' => 'string'],
                    'description' => ['type' => 'string'],
                    'image' => ['type' => 'string'],
                    'sort' => ['type' => 'integer'],
                    'active' => ['type' => 'integer'],
                    'is_brand' => ['type' => 'integer'],
                    'product_quant' => ['type' => 'integer'],
                    'max' => ['type' => 'integer'],
                    'min' => ['type' => 'integer'],
                    'tpl' => ['type' => 'string']
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