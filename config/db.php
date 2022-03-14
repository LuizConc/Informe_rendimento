<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlsrv:Server=' . getenv('DB_HOST') . ';Database=' . getenv('DB_DATABASE'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => getenv('DB_CHARSET'),
    'enableSchemaCache' => getenv('DB_CACHE'),
    'schemaCacheDuration' => getenv('DB_CACHE_DURATION'),
    'schemaCache' => 'cache',
];
