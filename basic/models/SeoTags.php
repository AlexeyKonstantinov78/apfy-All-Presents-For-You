<?php


namespace app\models;

use Yii;
//use app\modules\shop\models\Product;
//use app\modules\Page;
/**
 * This is the model class for table "seo_tags".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $object
 * @property integer $object_id
 * @property string $h1
 * @property string $slug
 */
class SeoTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo_tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id'], 'integer'],
            [['title'], 'string', 'max' => 256],
            [['description'], 'string', 'max' => 320],
            [['keywords'], 'string', 'max' => 250],
            [['object'], 'string', 'max' => 32],
            [['h1'], 'string', 'max' => 256],
            [['slug'], 'string', 'max' => 128],
            [['lasted'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'object' => 'Object',
            'object_id' => 'Object ID',
            'h1' => 'Заголовок',
            'slug' => 'Ссылка (чпу)',
            'lasted' => 'Последнее обновление страницы',
        ];
    }

    public function isEmpty()
    {
        return (!$this->h1 && !$this->title && !$this->keywords && !$this->description && !$this->slug);
    }

    public static function registerMetaTag($model,$obj = null)
    {
        /*
         * TODO
         * TO LOOK
         */
        //var_dump($obj);
        //var_dump($model);
//        exit;
        if($obj !== null && $model->object == 'Product' && empty($model->title)) {
            $model->title = empty($model->h1) ? $obj->name : $model->h1;
        }
        if($obj !== null && $model->object == 'Category' && empty($model->title)) {
            $model->title = empty($model->h1) ? $obj->name : $model->h1 .' в интернет-магазине APFY.RU';
        }
        if($obj !== null && $model->object == 'Product' && empty($model->description)) {
            $model->description = empty($model->h1) ? $obj->name : $model->h1.' за '.$obj->price.' в интернет-магазине APFY.RU - купить. Официальный дилер в Москве.';
        }
        if($obj !== null && $model->object == 'Category' && empty($model->description)) {
            $model->description = 'Купить '.empty($model->h1) ? $obj->name : $model->h1.' у официального дистрибьютора продукции Parker в России APFY.RU, тел.: +74951991825.';
        }
        if(strtolower($model->object) == 'articles') {
            $url = \yii::$app->request->referrer;
//            var_dump($url);
//            exit;
            $model->object = 'articles/novosti';
        } else if(strtolower($model->object) == 'articlecategory') {
            $model->object = 'articles';
        }
        if($model->slug != 'pervaya-stranica')
            \Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => 'https://apfy.ru/'.strtolower($model->object).'/'.$model->slug ]);
        else
            \Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => 'https://apfy.ru' ]);
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $model->description
        ]);

//        \Yii::$app->view->registerMetaTag([
//            'name' => 'keywords',
//            'content' => $model->keywords
//        ]);
//        var_dump($model->object);
//        exit;
        \Yii::$app->view->title = $model->title;

    }
}

