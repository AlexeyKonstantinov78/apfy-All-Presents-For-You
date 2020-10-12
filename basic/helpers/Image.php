<?php
namespace app\helpers;
use Yii;
use yii\helpers\FileHelper;
use app\helpers\GD;

class Image
{

    static function thumb($filename, $width = null, $height = null, $crop = true)
    {
        $root = Yii::getAlias('@webroot') . '/';
        if($filename && is_file(($image =  $root. '' . $filename)))
        {
            if(substr($filename,0,1) == '/') $im = "/_" . substr($filename,1);
            else $im = "_".$filename;

            $info = pathinfo($image);
            $thumbName = $info['filename'] . '-' . substr(md5(filemtime($image) . (int)$width . (int)$height),0,6) . '.' . $info['extension'];

            $thumbFile = $root . dirname($im) . "/" . $thumbName;


            $thumbWebFile = dirname($im) .  "/" . $thumbName;
            if(file_exists($thumbFile)){
                return $thumbWebFile;
            }

            elseif(FileHelper::createDirectory(dirname($thumbFile), 0777) && self::copyResizedImage($image, $thumbFile, $width, $height, $crop)){
                return $thumbWebFile;
            }
        }
        return '';
    }
    static function copyResizedImage($inputFile, $outputFile, $width, $height = null, $crop = true)
    {

        if (extension_loaded('gd'))
        {
            $image = new GD($inputFile);
            if($height) {
                if($width && $crop){
                    $image->cropThumbnail($width, $height);
                } else {
                    $image->resize($width, $height);
                }
            } else {
                $image->resize($width);
            }
            return $image->save($outputFile);
        }

        $image = new \Imagick($inputFile);

        $image->adaptiveResizeImage($width, $height);

        if($height && $crop){
            $image->cropThumbnailImage($width, $height);
        }

        $info = pathinfo($inputFile);
        if(in_array(strtolower($info['extension']),['jpeg','jpg']))
        {
            $image->setImageFormat('jpeg');
            $image->setImageCompressionQuality(80);
        }


        return $image->writeImage($outputFile);
    }
}