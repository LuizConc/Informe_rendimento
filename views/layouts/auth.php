<?php

/* @var $this \yii\web\View */
/* @var $content string */

// use Yii;
use app\widgets\Alert;
use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?= Url::to('@web/favicon.ico') ?>" type="image/x-icon">
  <link rel="icon" href="<?= Url::to('@web/favicon.ico') ?>" type="image/x-icon">
  <?php $this->registerCsrfMetaTags() ?>
  <title><?= Html::encode('Aker Solutions') ?></title>

  <!-- Assets --><?php $this->head() ?>
  <!-- PWA -->
  <!-- Web Application Manifest -->
  <link rel="manifest" href="<?= Url::to('@web/manifest.json') ?>">
  <!-- Chrome for Android theme color -->
  <meta name="theme-color" content="#038919">
  <!-- Add to homescreen for Chrome on Android -->
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="application-name" content="RENTAGRI">
  <link rel="icon" type="image/png" sizes="192x192" href="<?= Url::to('@web/android-icon-192x192.png') ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= Url::to('@web/favicon-32x32.png') ?>">
  <link rel="icon" type="image/png" sizes="96x96" href="<?= Url::to('@web/favicon-96x96.png') ?>">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= Url::to('@web/favicon-16x16.png') ?>">
  <!-- Add to homescreen for Safari on iOS -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="RENTAGRI">
  <link rel="apple-touch-icon" sizes="57x57" href="<?= Url::to('@web/apple-icon-57x57.png') ?>">
  <link rel="apple-touch-icon" sizes="60x60" href="<?= Url::to('@web/apple-icon-60x60.png') ?>">
  <link rel="apple-touch-icon" sizes="72x72" href="<?= Url::to('@web/apple-icon-72x72.png') ?>">
  <link rel="apple-touch-icon" sizes="76x76" href="<?= Url::to('@web/apple-icon-76x76.png') ?>">
  <link rel="apple-touch-icon" sizes="114x114" href="<?= Url::to('@web/apple-icon-114x114.png') ?>">
  <link rel="apple-touch-icon" sizes="120x120" href="<?= Url::to('@web/apple-icon-120x120.png') ?>">
  <link rel="apple-touch-icon" sizes="144x144" href="<?= Url::to('@web/apple-icon-144x144.png') ?>">
  <link rel="apple-touch-icon" sizes="152x152" href="<?= Url::to('@web/apple-icon-152x152.png') ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="<?= Url::to('@web/apple-icon-180x180.png') ?>">
  <!-- Tile for Win8 -->
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="<?= Url::to('@web/ms-icon-144x144.png') ?>">
</head>

<body class="bg-white">
  <?php $this->beginBody() ?>
  <?= Alert::widget() ?>
  <main id="app" class="d-flex flex-column h-100 justify-content-center">
    <div class="py-5">
      <div class="container mb-4 text-center"> 
        <img src="<?= Url::to('@web/img/logo.png') ?>" class="img-fluid" width="500"/>
      </div>
      <?= $content ?>
    </div>
  </main>
  <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>