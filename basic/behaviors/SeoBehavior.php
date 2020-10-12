<?php
namespace app\behaviors;
use Yii;
use yii\db\ActiveRecord;
use app\models\SeoTags;
class SeoBehavior extends \yii\base\Behavior
{
    private $_model;
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }
    public function afterInsert()
    {

        if($this->seoTags->load(Yii::$app->request->post())){
            if(!$this->seoTags->isEmpty()){
                $this->seoTags->object_id = $this->owner->primaryKey;
                $this->seoTags->save();
            }
        }
    }

    public function beforeInsert()
    {
        $this->seoTags->lasted = date("Y-m-d H:i:s");
    }

    public function beforeUpdate()
    {
        $this->seoTags->lasted = date("Y-m-d H:i:s");
    }

    public function afterUpdate()
    {
        if($this->seoTags->load(Yii::$app->request->post())){
            if(!$this->seoTags->isEmpty()){
                $this->seoTags->save();
            } else {
                if($this->seoTags->primaryKey){
                    $this->seoTags->delete();
                }
            }
        }
    }
    public function afterDelete()
    {
        if(!$this->seoTags->isNewRecord){
            $this->seoTags->delete();
        }
    }
    public function getSeo()
    {
        return $this->owner->hasOne(seoTags::className(), ['object_id' => $this->owner->primaryKey()[0]])->where(['object' => substr(strrchr(get_class($this->owner), "\\"), 1)]);
    }
    public function getseoTags()
    {
        if(!$this->_model)
        {
            $this->_model = $this->owner->seo;
            if(!$this->_model){
                $this->_model = new seoTags([
                    'object' => substr(strrchr(get_class($this->owner), "\\"), 1),
                    'object_id' => $this->owner->primaryKey
                ]);
            }
        }
        return $this->_model;
    }
}