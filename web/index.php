<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
/**
 * Fast Debug Function
 */
function pr($data, $die = FALSE)
{
  echo '<pre>';
  print_r($data);
  echo '</pre>';
  if ($die)
    die();
}
$autoload = __DIR__ . '/../vendor/autoload.php';

if (!file_exists($autoload)) {
  pr('Bibliotecas não instaladas. É necessário rodar o Composer.');
  die();
}
require $autoload;

$fileEnvExist = file_exists('../.env');
if(!$fileEnvExist){
  header('Location: install.php');
  die();
}
$env = require __DIR__ . '/../config/env.php';

defined('YII_DEBUG') or define('YII_DEBUG', getenv('APP_DEBUG'));
defined('YII_ENV') or define('YII_ENV', getenv('APP_ENV'));
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();