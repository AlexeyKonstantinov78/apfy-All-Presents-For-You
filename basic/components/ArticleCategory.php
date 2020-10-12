<?php

namespace app\components;

use Yii;
use app\behaviors\SeoBehavior;
use app\behaviors\ImageBehavior;
use app\behaviors\AdjacencyListBehavior;
use app\models\SeoTags;
use app\models\Images;
/**
 * This is the model class.
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $parent_id
 */
class ArticleCategory extends \yii\db\ActiveRecord
{

    const attrname = 'name';
    # protected $attrsort = 'sort';

    public function afterValidate()
    {
        return true;
    }

    public function behaviors()
    {
        return [
            'imageBehavior' => ImageBehavior::className(),
            'seoBehavior' => SeoBehavior::className(),
            [
                'class' => AdjacencyListBehavior::className(),
            ]
        ];
    }

    public static function generateTree()
    {
        $tree = array();
        # Добавить кеш $tree
        $roots = self::getRoots();
        foreach($roots as $root)
            $tree[$root->id] = $root->populateTree();

        return $tree;
    }

    public static function generateTreeJs($options = [])
    {
        $tree = self::generateTree();
        $treejs = array();
        $expanded = array();

        if(isset($options['expanded']) && $options['expanded'] == 'all')
            $expanded = ['expanded'=>true];

        foreach($tree as $el)
        {
            $array = ['key'=>$el->id, 'title'=>$el->{self::attrname}, 'folder' => true, 'children' => $el->generateChildrenJs($options)];
            if(isset($options[$el->id]))
                if(is_array($options[$el->id])) $array = array_merge($array, $options[$el->id]);

            $array = array_merge($array, $expanded);
            $treejs[] = $array;
        }

        return $treejs;
    }

    public function generateChildrenJs($options)
    {
        if($this->isLeaf()) return;
        $childrens = $this->children;

        $expanded = array();

        if(isset($options['expanded']) && $options['expanded'] == 'all')
            $expanded = ['expanded'=>true];

        foreach($childrens as $ch)
        {
            $childrenjs = ['key'=>$ch->id, 'title'=>$ch->{self::attrname}, 'folder' => true];
            if(isset($options[$ch->id]))
                if(is_array($options[$ch->id])) $childrenjs = array_merge($childrenjs, $options[$ch->id]);

            $childrenjs = array_merge($childrenjs, $expanded);

            if(!$ch->isLeaf())  $childrenjs['children'] = $ch->generateChildrenJs($options);
            $childrensjs[] = $childrenjs;
        }
        return $childrensjs;
    }

    public function getSeo()
    {
        return $this->hasOne(seoTags::className(), ['object_id' => 'id'])->where(['object' => substr(strrchr(get_class($this), "\\"), 1)]);
    }

    public static function getRoots()
    {
        # Добавить кеш запроса
        return self::find()->with('seo')->where(["parent_id"=>null])->orderBy('sort')->all();
    }

    public static function generateTreeCat($max_level=false, $with_id=null, $with_ParentId=null)
    {
        $tree = array();

        $roots = self::getRootsWithParentId($with_ParentId);

        foreach($roots as $root)
            $tree[$root->id] = $root->populateTree();
        return $tree;
    }

    public static function getRootsWithParentId($with_ParentId=null)
    {

        # Добавить кеш запроса
        return self::find()->with('seo')->where(['parent_id'=>$with_ParentId, 'active' => '1'])->orderBy('sort')->all();
    }

}
