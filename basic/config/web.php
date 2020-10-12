<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
	'bootstrap'    => ['assetsAutoCompress'],
    //'bootstrap' => ['log'],
    'components' => [
		'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
			'autodetectCluster' => false,
            'nodes' => [
				['http_address' => '127.168.0.1:9221'],
                //'autodetectCluster ' => false,
            ],

        ],
        'session'=>[
            'timeout'=>5*24*60*60,
        ],
		'assetsAutoCompress' =>
        [
            'class'         => '\skeeks\yii2\assetsAuto\AssetsAutoCompressComponent',
			'enabled'                       => false,

            'readFileTimeout'               => 10,            //Time in seconds for reading each asset file

            'jsCompress'                    => true,        //default = true //Enable minification js in html code
            'jsCompressFlaggedComments'     => true,        //default = true //Cut comments during processing js

            'cssCompress'                   => true,        //default = true //Enable minification css in html code

            'cssFileCompile'                => false,        //default = true //Turning association css files
            'cssFileRemouteCompile'         => false,       //Trying to get css files to which the specified path as the remote file, skchat him to her.
            //'cssFileCompress'               => true,        //Enable compression and processing before being stored in the css file
            'cssFileCompress'               => false,        //Enable compression and processing before being stored in the css file
            'cssFileBottom'                 => false,       //Moving down the page css files
            'cssFileBottomLoadOnJs'         => false,       //Transfer css file down the page and uploading them using js

            'jsFileCompile'                 => false,        //Turning association js files
            'jsFileRemouteCompile'          => true,       //Trying to get a js files to which the specified path as the remote file, skchat him to her.
            'jsFileCompress'                => true,        //Enable compression and processing js before saving a file
            'jsFileCompressFlaggedComments' => true,        //Cut comments during processing js

            'htmlCompress'                  => true,        //Enable compression html
            'noIncludeJsFilesOnPjax'        => true,        //Do not connect the js files when all pjax requests
            'htmlCompressOptions'           =>              //options for compressing output result
            [
                'extra' => false,        //use more compact algorithm
                'no-comments' => true   //cut all the html comments
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'key',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Users',
            'loginUrl' => ['cabinet/auth'],
            'enableAutoLogin' => true,
        ],
		/*
        'useroot' => [
            'identityClass' => 'app\components\UserootComponent',
            'enableAutoLogin' => true,
        ],
		//*/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //'useFileTransport' => true,
            'useFileTransport' => false,
            //вроде работает
            //*
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'ssl://smtp.yandex.com',
                'username' => 'mail@mail.ri',
                'password' => 'password',
                'port' => '465',
				//'encryption' => 'tsl',
            ],
			//'encryption' => 'tls',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            'rules' => [
				'<controller:(product)>/ajax-product/<id:[\d]+>' => 'shop/<controller>/ajax-product',
                '<controller:(category)>' => 'shop/<controller>/index',
                '<controller:(category)>/<slug:[\w-]+>/<page>-<per-page>' => 'shop/<controller>/view',
                '<controller:(category|product)>/<slug:[\w-]+>' => 'shop/<controller>/view',
                '<action:search>/<query>/<page>' => 'shop/product/<action>',
                '<action:searchlong>' => 'shop/product/<action>',


                '<action:search>/<query>' => 'shop/product/<action>',

                '<controller:(page)>/<slug:[\w-]+>' => '<controller>/index', //к ссылки добавляем page+url страницы
                '<controller>/<action>/<id:\d+>' => '<controller>/<action>',


                'articles/<slug:[\w-]+>' => 'articles/view',                   //к ссылки добавляем articles+url_cat+urlart страницы
                'articles/<cat:[\w-]+>/<slug:[\w-]+>' => 'articles/index',      //к ссылки добавляем articles+url_cat страницы

                '<controller>/<action>' => '<controller>/<action>',
                //'category/<slug:[\w]+>' => 'shop/category/view',
                /*

                '<c:category>/<slug:[\w-]+>/<page>-<per-page>' => 'shop/<controller>/view',
                '<c:(category|product)>/<slug:[\w-]+>' => '<controller>/view',
                '<c:(page)>/<slug:[\w-]+>' => '<controller>/index',
                '<c>/<action>/<id:\d+>' => '<controller>/<action>',
                '<c>/<action>' => '<controller>/<action>',
                //*/
            ],
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],

        'assetManager' => [
            'linkAssets' => true,
            //'appendTimestamp' => true, //To overcome this drawback, you may use the cache busting feature, which was introduced in version 2.0.3, by configuring yii\web\AssetManager
            'bundles' => require(__DIR__ . '/assets_config/assets-prod.php'),
            //'bundles' => require(__DIR__ . '/assets_config/' . (YII_ENV_PROD ? 'assets-prod.php' : 'assets-dev.php')),
        ],*/
		'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true, //cache
            /* добавление async
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'jsOptions' => [
                        'async' => 'async'
                    ],
                ],
            ],
            //*/
        ],
    ],
	'modules' => [
        'root' => [
            'class' => 'app\modules\root\Root',
            'layout' => 'root',
        ],
		'shop' => [
            'class' => 'app\modules\shop\Shop',
        ],
        'cabinet' => [
            'class' => 'app\modules\cabinet\Cabinet',
        ],
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => ['@'], //доступ к записи
            'disabledCommands' => ['netmount'], //отключение ненужных команд
            'root' => [
                'baseUrl'=>'@web/uploads',
                'basePath'=>'@webroot/uploads',
                'access' => ['read' => '*', 'write' => '*'],
                'name' => 'uploads'
            ],
        ],
    ],
    'params' => $params,
];


//* DEBUG BUG
if(YII_DEBUG){
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*.*.*.*', '::1'],
    ];
}
//if (YII_ENV_DEV || isset($_GET['deb'])) {
if (YII_DEBUG) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*.*.*.*', '::1'],
    ];
}

//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//        // uncomment the following to add your IP if you are not connecting from localhost.
//        'allowedIPs' => ['*.*.*.*', '::1'],
//    ];
// DEBUG BUG
//$config['bootstrap'][] = 'debug';
//$config['modules']['debug'] = [
//    'class' => 'yii\debug\Module',
//    // uncomment the following to add your IP if you are not connecting from localhost.
//    'allowedIPs' => ['*.*.*.*', '::1'],
//];
//
//$config['bootstrap'][] = 'gii';
//$config['modules']['gii'] = [
//    'class' => 'yii\gii\Module',
//    // uncomment the following to add your IP if you are not connecting from localhost.
//    'allowedIPs' => ['*.*.*.*', '::1'],
//];



return $config;
