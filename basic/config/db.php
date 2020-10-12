<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=dbname',
    'username' => 'dbname',
    'password' => 'password',
    'charset' => 'utf8',
	'enableSchemaCache' => false,
	// Duration of schema cache.
	'schemaCacheDuration' => 36000,

	// Name of the cache component used to store schema information
	'schemaCache' => 'cache',
];
