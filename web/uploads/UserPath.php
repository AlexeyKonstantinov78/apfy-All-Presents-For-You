<?php
namespace app\components;

use Yii;
use mihaildev\elfinder\LocalPath;
use app\models\Users;

class UserPath extends LocalPath{
	
	public $domain;
	
	public function isAvailable(){
		if(Yii::$app->user->isGuest)
			return false;
		if(isset(\Yii::$app->session['user_id'])) $id = \Yii::$app->session['user_id'];
		else $id = Yii::$app->user->id;
		
		$model = Users::findOne($id);
		$this->domain = $model->domain;
		
		return parent::isAvailable();
	}
	public function getUrl(){
		$path = '/uploads';
		
		return Yii::getAlias($this->baseUrl.'/'.trim($path,'/'));
	}
	public function getRealPath(){
		$path = 'static/'.$this->domain.'/uploads';
		$path = Yii::getAlias($this->basePath.'/'.trim($path,'/'));
		
		if(!is_dir($path))
			mkdir($path, 0777, true);
		return $path; 
	}
}