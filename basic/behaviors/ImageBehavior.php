<?php
namespace app\behaviors;
use Yii;
use yii\db\ActiveRecord;
use app\models\Images;
use yii\base\Model;

class ImageBehavior extends \yii\base\Behavior
{
    private $_model;
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }
    public function afterInsert()
    {
        if(!empty(Yii::$app->request->post('Images'))){
            foreach(Yii::$app->request->post('Images') as $k => $v){
				$model_image = new Images();

				$model_image->title = !empty($v['title']) ? $v['title'] : '';

				$model_image->alt = !empty($v['alt']) ? $v['alt'] : '';
				$model_image->image = !empty($v['image']) ? $v['image'] : '';
				$model_image->is_main = isset($v['is_main']) ? $v['is_main'] : 0;
				$model_image->object = substr(strrchr(get_class($this->owner), "\\"), 1);
				$model_image->object_id = $this->owner->id;
				$model_image->save();
			}
        }
    }

	//TOLOOK
    public function afterUpdate()
    {
		if(Yii::$app->request->post('Images') !== null){
			if (is_array($this->Images) && Images::loadMultiple($this->Images, Yii::$app->request->post())) {
				foreach ($this->Images as $key => $image) {
					$id_old = $image->id;
					$post = Yii::$app->request->post()['Images'];
					$array_out = array_filter($post, function($p) use($id_old) {
						if(isset($p['id']) && $p['id'] == $id_old && $p['delete'] == 0) {
							$res = true;
						} else {
							$res = false;
						}
						return $res; //in_array($var, $image) ? true : false;
					});

					if(!empty($array_out)){
						$image->save();
					} else {
						$image->delete();
					}
				}
			}

			foreach(Yii::$app->request->post('Images') as $k => $v){
			    //TODO
				if(isset($v['is_main']) && $v['is_main'] == 1) {
                    if(substr(strrchr(get_class($this->owner), "\\"), 1) == 'Category'){
                        if(Images::find()
                                ->where(['object_id' => $this->owner->id, 'object'=> substr(strrchr(get_class($this->owner), "\\"), 1)])
                                ->one() == null){
                            $model_image = new Images();
                            $model_image->title = !empty($v['title']) ? $v['title'] : '';
                            $model_image->alt = !empty($v['alt']) ? $v['alt'] : '';
                            $model_image->image = !empty($v['image']) ? $v['image'] : '';
                            $model_image->is_main = isset($v['is_main']) ? $v['is_main'] : 0;
                            $model_image->object = substr(strrchr(get_class($this->owner), "\\"), 1);
                            $model_image->object_id = $this->owner->id;
                            $model_image->save();
                        }
                    }
                    Continue;
                }
				if(!array_key_exists('id', $v)){
					$model_image = new Images();
					$model_image->title = !empty($v['title']) ? $v['title'] : '';
					$model_image->alt = !empty($v['alt']) ? $v['alt'] : '';
					$model_image->image = $v['image'];
					$model_image->is_main = 0;
					$model_image->object = substr(strrchr(get_class($this->owner), "\\"), 1);
					$model_image->object_id = $this->owner->id;
					$model_image->save();
				} else {

                }
			}
		}
    }

    public function afterDelete()
    {
        return Images::deleteAll(['object_id' => $this->owner->id, 'object'=> substr(strrchr(get_class($this->owner), "\\"), 1)]);
    }

    public function getImgs()
    {
        return $this->owner->hasMany(Images::className(), ['object_id' => $this->owner->primaryKey()[0]])->where(['object' => substr(strrchr(get_class($this->owner), "\\"), 1)])->orderBy(['is_main'=>SORT_DESC, 'id'=>SORT_ASC]);
    }

    public function getImages()
    {
        if(!$this->_model)
        {
            $this->_model = $this->owner->imgs;
            if(!$this->_model){
                $this->_model = new Images([
                    'object' => substr(strrchr(get_class($this->owner), "\\"), 1),
                    'object_id' => $this->owner->primaryKey
                ]);
            }
        }
        return $this->_model;
    }
	public function getImg(){
		return $this->owner->hasone(Images::className(), ['object_id' => $this->owner->primaryKey()[0]])->where(['object' => substr(strrchr(get_class($this->owner), "\\"), 1), 'is_main'=>'1']);
	}

	//TOLOOK
	protected function findModelImage($id)
    {
        if (($model = Images::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	//*
	public function getMainImage()
    {

        if(!$this->_model)
        {
            $this->_model = $this->owner->img;
            if(!$this->_model){
                $this->_model = new Images([
                    'object' => substr(strrchr(get_class($this->owner), "\\"), 1),
                    'object_id' => $this->owner->primaryKey,
					'is_main' => '1'
                ]);
            }
        } else {
			$this->_model = $this->owner->img;
			if(!$this->_model){
                $this->_model = new Images([
                    'object' => substr(strrchr(get_class($this->owner), "\\"), 1),
                    'object_id' => $this->owner->primaryKey,
					'is_main' => '1'
                ]);
            }
		}
        return $this->_model;
    }


//	public function getMainImageNew()
//    {
//        if(!$this->_model)
//        {
//            $this->_model = $this->owner->img;
//            if(!$this->_model){
//                $this->_model = new Images([
//                    'object' => substr(strrchr(get_class($this->owner), "\\"), 1),
//                    'object_id' => $this->owner->primaryKey,
//					'is_main' => '1'
//                ]);
//            }
//        } else {
//			$this->_model = $this->owner->img;
//			if(!$this->_model){
//                $this->_model = new Images([
//                    'object' => substr(strrchr(get_class($this->owner), "\\"), 1),
//                    'object_id' => $this->owner->primaryKey,
//					'is_main' => '1'
//                ]);
//            }
//		}
//        return $this->_model;
//    }
}
