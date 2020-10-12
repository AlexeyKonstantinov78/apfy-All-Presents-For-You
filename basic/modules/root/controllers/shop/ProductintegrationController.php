<?php
namespace app\modules\root\controllers\shop;

use Yii;

use Zenwalker\CommerceML\CommerceML;
use Zenwalker\CommerceML\Model\Category;
use Zenwalker\CommerceML\Model\Property;
use app\modules\shop\models\UploadIntegration;
use app\modules\shop\models\Product;
use yii\web\UploadedFile;
use app\modules\root\controllers\DefaultController;

class ProductintegrationController extends DefaultController
{
	private $_ids;
	private $_new;
	private $_edit;
	
	
	public function actionFile()
	{
		$model = new UploadIntegration();

        if (Yii::$app->request->isPost) {
            $model->import = UploadedFile::getInstance($model, 'import');
            if ($model->upload()) {
                $this->actionImport();
            }
        }
		
		return $this->render('upload', ['model' => $model, 'result' => [$this->_new, $this->_edit]]);
	}

	public function parsing($import, $offers)
    {
        $this->_ids = [];
        $commerce = new CommerceML();
        $commerce->addXmls($import, $offers);
		$i0 = 0;
		$i1 = 0;
			
        foreach ($commerce->getProducts() as $product) {
					
			$model = Product::find()->where(['id_int'=>$product->id])->one();
			$product->description = str_replace(["\r\n","\n"], ["<br>","<br>"], $product->description);
			//$product->name = trim(str_replace(["\t","   ","  "], [" "," "," "], $product->name)); 
			//$product->sku; //поле с артикулом
			$tmp_name = '';
			foreach($product->requisites as $k=>$v){
				if($v['name'] === 'Полное наименование'){
					$tmp_name = trim(str_replace(["\t","   ","  "], [" "," "," "], $v['value']));
					break;
				} 
			}		
			$product->name = empty($tmp_name) ? $product->name : $tmp_name;
			$product->name = trim(str_replace(["\t","   ","  "], [" "," "," "], $product->name));
			if ($model !== null) {
				if($product->name != $model->name || $product->price[0]->cost != $model->price || trim($model->description) != trim($product->description) || trim($model->artid) != trim($product->sku)) {
					$model->description = $product->description;
					$model->price = $product->price[0]->cost;
					$model->name = $product->name;
					$model->artid = trim($product->sku);
					$model->save(false);
					
					$s = \app\models\SeoTags::find()->where(['object' => 'Product', 'object_id' => $model->id])->one();
					if(!is_null($s)) {
						$s->lastmod = date("Y-m-d H:i:s");
						$s->save(false); 
					}
					
					$this->_edit[] = ['id_int' => $model->id_int, 'id' => $model->id];
				}
			} else {
				$model = new Product();
				$model->id_int = $product->id;
				$model->artid = trim($product->sku);
				$model->name = $product->name;
				$model->description = $product->description;
				$model->price = $product->price[0]->cost;

				$model->save(false);
				
				$seo = new \app\models\SeoTags();
				$seo->setSlugRusLat($model->name);
				
				$s = \app\models\SeoTags::find()->where(['slug'=>$seo->slug])->one();
				if($s !== null) $seo->slug = $model->id.'-'.$seo->slug;
				
				$seo->object_id = $model->id;
				$seo->object = 'Product';
				$seo->save();
	
				$this->_new[] = ['id_int' => $model->id_int, 'id' => $model->id];
			}
        }
    }
    public function actionLoad()
    {
        set_time_limit(0);
        $import = self::getTmpDir() . DIRECTORY_SEPARATOR . 'import0_1.xml';
        $offers = self::getTmpDir() . DIRECTORY_SEPARATOR . 'offers0_1.xml';
        $this->parsing($import, $offers);
    }
    public function actionImport()
    {
        
		$zip = new \ZipArchive();
		$path = self::getTmpDir() . DIRECTORY_SEPARATOR . 'import.zip';
		
		if ($zip->open($path) === true) {
			for($i = 0; $i < $zip->numFiles; $i++) {
				$filename = $zip->getNameIndex($i);
				$fileinfo = pathinfo($filename);
				
				if(isset($fileinfo['extension'])) {
					copy("zip://".$path."#".$filename, self::getTmpDir() . DIRECTORY_SEPARATOR . $fileinfo['basename']); 
				}
			}                   
			$zip->close();                   
		}
		

        $import = self::getTmpDir() . DIRECTORY_SEPARATOR . 'import0_1.xml';
        $offers = self::getTmpDir() . DIRECTORY_SEPARATOR . 'offers0_1.xml';
        $this->parsing($import, $offers);

        $this->clearTmp();

        return true;
    }
    protected function clearTmp()
    {

        if (file_exists($import = self::getTmpDir() . DIRECTORY_SEPARATOR . 'import0_1.xml')) {
            @unlink($import);
        }
        if ($offers = self::getTmpDir() . DIRECTORY_SEPARATOR . 'offers0_1.xml') {
            @unlink($offers);
        }
    }
	
	protected function getTmpDir()
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'tmp';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        return $dir;
    }
	

}