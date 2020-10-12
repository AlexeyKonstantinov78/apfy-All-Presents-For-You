<?php
/**
 * Created by PhpStorm.
 * User: straengel
 * Date: 30.11.2016
 * Time: 20:49
 * max_level - максимальный уровень вложенности
 * with_ParentId - выбирает по parent_id
 * with_id - выбирает по id
 * все выше перечисленные переменные имеют значение null по умолчанию
 * если нет with_id, то действует выбирает по with_ParentId (parent_id)
 * на будущие:
 * - сделать возможность выбора категорий товары или статье или еще какая нить хни )))
 */
namespace app\widgets\menu;
use Yii;
use yii\base\Widget;
use app\modules\shop\models\Category;
use app\models\ArticleCategory;



class MenuWidget extends Widget{
    public $id_menu;
    public $tmp_menu = '';
	public $max_level = false;
	public $with_id = null;
	public $with_ParentId = null;
    public function init(){
        parent::init();
    }

    public function dropdownmenu($controller_id, $drop_menu){
        if (in_array($controller_id, $drop_menu)) {
            $drop_active['aria-expanded'] = 'aria-expanded="true"';
            $drop_active['class'] = 'in';
        }
        else {
            $drop_active['aria-expanded'] = 'aria-expanded="false"';
            $drop_active['class'] = '';
        }
        return $drop_active;
    }

    public function run(){
        //$tree = $model_cat->generateTreeCat($max_level=$this->max_level, $with_id=$this->with_id, $with_ParentId=$this->with_ParentId); //если есть with_id != null то не действует with_ParentId
        if($this->tmp_menu == 'aside_admin' || $this->tmp_menu == 'top_admin' || $this->tmp_menu == 'top_admin_main'){
			$tree = false;
		} elseif($this->tmp_menu == 'filter_cat_admin') {
            $model_cat = new Category();
            /* test
            var_dump($this->tmp_menu);
            var_dump($this->max_level);
            var_dump($this->with_id);
            var_dump($this->with_ParentId);
            exit;
            //*/
            //* Cache
            $tree = Yii::$app->cache->get('cacheMenu'.$this->tmp_menu);
            //$tree = false; //отключить кеш
            if ($tree === false) {
                $tree = $model_cat->generateTreeCat($max_level=$this->max_level, $with_id=$this->with_id, $with_ParentId=$this->with_ParentId);
                Yii::$app->cache->set('cacheMenu'.$this->tmp_menu, $tree, 10000);
            }
        } elseif($this->tmp_menu == 'filter_cat_art_admin') {
            $model_cat = new ArticleCategory();
            /* test
            var_dump($this->tmp_menu);
            var_dump($this->max_level);
            var_dump($this->with_id);
            var_dump($this->with_ParentId);
            exit;
            //*/
            //* Cache
            $tree = Yii::$app->cache->get('cacheMenu'.$this->tmp_menu);
            $tree = false; //отключить кеш
            if ($tree === false) {
                $tree = $model_cat->generateTreeCat($max_level=$this->max_level, $with_id=$this->with_id, $with_ParentId=$this->with_ParentId);
                Yii::$app->cache->set('cacheMenu'.$this->tmp_menu, $tree, 10000);
            }
		} else {
			$model_cat = new Category();
            //* Cache
            $tree = Yii::$app->cache->get('cacheMenu'.$this->tmp_menu);
            //$tree = false; //отключить кеш
            if ($tree === false) {
                $tree = $model_cat->generateTreeCat($max_level=$this->max_level, $with_id=$this->with_id, $with_ParentId=$this->with_ParentId);
                Yii::$app->cache->set('cacheMenu'.$this->tmp_menu, $tree, 10000);
            }
            //*/
            //$tree = $model_cat->generateTreeCat($max_level=$this->max_level, $with_id=$this->with_id, $with_ParentId=$this->with_ParentId);
		}
		//var_dump($tree);
		//exit();



        return $this->render($this->tmp_menu, [
            'tree' => $tree,
			'max_level' => $this->max_level,
        ]);
    }

}
?>