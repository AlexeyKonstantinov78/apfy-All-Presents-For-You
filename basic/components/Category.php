<?php

namespace app\components;

use Yii;
use app\behaviors\SeoBehavior;
use app\behaviors\AdjacencyListBehavior;
use app\models\SeoTags;
use app\models\Images;
use app\behaviors\ImageBehavior;
use app\modules\shop\models\ProductInCategory;
use app\modules\shop\models\Product;
/**
 * This is the model class.
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $parent_id
 * max_level - максимальный уровень вложенности
 * with_ParentId - выбирает по parent_id
 * with_id - выбирает по id
 * все выше перечисленные переменные имеют значение null по умолчанию
 * если нет with_id, то действует выбирает по with_ParentId (parent_id)
 */
class Category extends \yii\db\ActiveRecord
{

	const attrname = 'name';
	# protected $attrsort = 'sort';


	public function behaviors()
    {
        return [
            'imageBehavior' => ImageBehavior::className(),
            'seoBehavior' => SeoBehavior::className(),
			[
                'class' => AdjacencyListBehavior::className()
            ],
            //'imageBehavior' => ImageBehavior::className(),
        ];
    }

    //вернуть последних потомков
    public static function getLastChild($tree, $result=[]){

        foreach ($tree as $k => $v){

            if($v->isLeaf() == false){
                $result = $result+self::getLastChild($v->children, $result);
            } else {
                $result[$v->id] = $v->name;
            }

        }
        return $result;
    }

    //вернуть последнего потомка товара
    public static function getLastChildProductArray($lastChilds, $productsCats){
        foreach ($productsCats as $k=>$v){
            if (array_key_exists($v['id'], $lastChilds)) {
                return $v['id'];
            }
        }
    }
    public static function getLastChildProductObject($lastChilds, $productsCats){
        foreach ($productsCats as $k=>$v){
            if (array_key_exists($v->id, $lastChilds)) {
                return $v->id;
            }
        }
    }

    //Генерация массива из id и parent_id
    public static function generateTreeCatParent($id = null)
    {
        if($id == null) return false;
        $tree = self::getRootsWithId($id);

        foreach($tree as $el)
        {

            $treeJs[$el->id] = ['name'=>$el->{self::attrname}, 'parent_id'=>null];
            if(!$el->isLeaf()){
                $treeJs = $treeJs+$el->generateChildrenCatParent($treeJs);
            }
        }
        return $treeJs;
    }


    public function generateChildrenCatParent( $treeJs = [])
    {

        $childrens = $this->children;
        foreach($childrens as $ch){
            if($ch->isLeaf()) {
                $treeJs[$ch->id] = ['name'=>$ch->{self::attrname}, 'parent_id'=>$ch->parent_id];

            }
            if(!$ch->isLeaf()) {
                $treeJs[$ch->id] = ['name'=>$ch->{self::attrname}, 'parent_id'=>$ch->parent_id];

                $treeJs = $ch->generateChildrenCatParent( $treeJs);
            }
        }
        return $treeJs;
    }

    /**
     * @return string
     */
    //TODO
    //Переделать фильтры
    public static function generateBadFiltresCats($cats)
    {
        //чуть поправил, но это ТАКОЙ пиздец, в общем подправил
        $i = 0;
        $results = array();
        foreach ($cats as $k => $v) {
            if($v['id_category'] == null) Continue;
            $tree = self::getRootsWithId($v['id_category']);
            foreach ($tree as $k1 => $v1 ){
                if(!$v1->isLeaf()) {
                    $results[$i]['root'] = [
                        'name' => $v1->name,
                        'id' => $v1->id
                    ];
                    foreach ($v1->getChildren()->all() as $k2 => $v2){
                        $cnt = Category::find()->select(['cnt' => 'sum(if(product.active = 0, 0, 1))', 'category.id'])->joinWith(['products'])->where(['category.id' => $v2->id])->asArray()->one();
                        $results[$i]['root']['children'][] = [
                            'name' => $v2->name,
                            'url' => '/category/'.$v2->seoTags->slug,
                            'count' => $cnt['cnt'],
                            //'count' => ProductInCategory::find()->where(['id_category' => $v2->id])->count(),
                            'id' => $v2->id
                        ];
                    }
                    $i++;
                }
            }
        }
        /* вот так было, не на много конечно лучше стало, но терь есть куда думать TODO TO LOOK
        $i = 0;
        $results = array();
        $tree = array();
        foreach ($cats as $k=>$v){
            $tree = self::generateTreeCat(false, $v['id_category']);
            foreach ($tree as $k1=>$v1){
                if(!$v1->isLeaf()) {
                    $results[$i]['root']=[
                        'name' => $v1->name,
                        'id' => $v1->id
                    ];
                    foreach ($v1->getChildren()->all() as $k2 => $v2){
                        $cnt = Category::find()->select(['cnt' => 'sum(if(product.active = 0, 0, 1))', 'category.id'])->joinWith(['products'])->where(['category.id' => $v2->id])->asArray()->one();
                        $results[$i]['root']['children'][] = [
                            'name' => $v2->name,
                            'url' => '/category/'.$v2->seoTags->slug,
                            'count' => $cnt['cnt'],
                            //'count' => ProductInCategory::find()->where(['id_category' => $v2->id])->count(),
                            'id' => $v2->id
                        ];
                    }
                    $i++;
                } else {
                    $results = null;
                    break;
                }

            }
        }
        /**/

        return $results;
    }

    //edit потом переделать
    //Генерирует одномерный массив всех детей
    public static function generateTreeEditCatArr($id = null)
    {
        if($id == null) return false;
        $tree = self::getRootsWithId($id);

        foreach($tree as $el)
        {

            $treeJs[$el->id] = $el->{self::attrname};
            if(!$el->isLeaf()){
                $treeJs = $treeJs+$el->generateChildrenEditJsArr($treeJs);
            }
        }
        return $treeJs;
    }


    public function generateChildrenEditJsArr( $treeJs = [])
    {

        $childrens = $this->children;
        foreach($childrens as $ch){
            if($ch->isLeaf()) {
                $treeJs[$ch->id] = $ch->{self::attrname};

            }
            if(!$ch->isLeaf()) {
                $treeJs[$ch->id] = $ch->{self::attrname};

                $treeJs = $ch->generateChildrenEditJsArr( $treeJs);
            }
        }
        return $treeJs;
    }

    //edit потом переделать
    public static function generateTreeEditCat($dash = '--', $treeJs = array())
    {
        $tree = self::generateTree();

        foreach($tree as $el)
        {

            $treeJs[$el->id] = $el->{self::attrname};
            if(!$el->isLeaf()){
                $treeJs = $treeJs+$el->generateChildrenEditJs($dash, $treeJs);
            }
        }
        return $treeJs;
    }
    public function generateChildrenEditJs($dash, $treeJs = [])
    {
        $childrens = $this->children;
        foreach($childrens as $ch){
            if($ch->isLeaf()) {
                $treeJs[$ch->id] = $dash.$ch->{self::attrname};

            }
            if(!$ch->isLeaf()) {
                $treeJs[$ch->id] = $dash.$ch->{self::attrname};

                $treeJs = $ch->generateChildrenEditJs($dash.'--', $treeJs);
            }
        }
        return $treeJs;
    }

	public static function generateTree()
    {
		$tree = array();
		$roots = self::getRoots();

		foreach($roots as $root)
            $tree[$root->id] = $root->populateTree();

        //TODO
		# Добавить кеш $tree

		return $tree;
    }


    //начать с определенной категории
	public static function generateTreeCat($max_level=false, $with_id=null, $with_ParentId=null)
    {
		$tree = array();

		if($with_id != null)
			$roots = self::getRootsWithId($with_id);
		else
			$roots = self::getRootsWithParentId($with_ParentId);

		foreach($roots as $root)
				$tree[$root->id] = $root->populateTree();

		return $tree;
    }



    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'id_product'])->viaTable('product_in_category',  ['id_category' => 'id']);
    }

	public static function generateTreeJs($options = [], $id=null)
	{
	    if($id != null){
            $tree =  self::generateTreeCat(false, $id);
        } else {
            $tree = self::generateTree();
        }
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
        return $this->hasOne(seoTags::className(), ['object_id' => 'id'])->where(['object' => substr(strrchr(get_class($this), '\\'), 1)]);
    }

	public static function getRoots()
	{
		# Добавить кеш запроса
		return self::find()->with('seo')->where(['parent_id'=>null])->orderBy('sort')->all();
	}

	public static function getRootsWithParentId($with_ParentId=null)
	{

		# Добавить кеш запроса
		return self::find()->with('seo')->where(['parent_id'=>$with_ParentId, 'active' => '1'])->orderBy('sort')->all();
	}


	public static function getRootsWithId($with_id=null)
	{
		if($with_id != null){
			$result = self::find()->with('seo')->where(['id'=>$with_id, 'active' => '1'])->orderBy('id')->all();;
		} else {
			$result = self::getRootsWithParentId();
		}
		# Добавить кеш запроса
		return $result;
	}

}
