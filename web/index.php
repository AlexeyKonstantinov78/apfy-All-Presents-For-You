<?php
// comment out the following two lines when deployed to production
//Для тестировки
//defined('YII_DEBUG') or define('YII_DEBUG', true);
//defined('YII_ENV') or define('YII_ENV', 'dev');
//Для релиза
//defined('YII_DEBUG') or define('YII_DEBUG', false);
//defined('YII_ENV') or define('YII_ENV', 'prod');
if($_SERVER['REMOTE_ADDR'] == '95.66.160.248'){
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
} else {
    defined('YII_DEBUG') or define('YII_DEBUG', false);
    defined('YII_ENV') or define('YII_ENV', 'prod');
}
require(__DIR__ . '/../basic/vendor/autoload.php');
require(__DIR__ . '/../basic/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../basic/config/web.php');

(new yii\web\Application($config))->run();