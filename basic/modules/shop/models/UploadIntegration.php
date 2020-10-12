<?php 
namespace app\modules\shop\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadIntegration extends Model
{
    /**
     * @var UploadedFile
     */
    public $import;

    public function rules()
    {
        return [
            [['import'], 'file', 'skipOnEmpty' => false, 'extensions' => 'zip'],
        ];
    }
     
    public function upload()
    {
        if ($this->validate()) {
			
			$dir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'tmp';
		
			if (!is_dir($dir)) {
				mkdir($dir, 0777, true);
			}
			
            $this->import->saveAs($dir.'/import.zip');
            return true;
        } else {
            return false;
        }
    }
}
?>