<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\components\ThumbHelper;
use app\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use app\models\Lead;
use yii\helpers\Url;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <?= Html::csrfMetaTags() ?>
  <title><?= $this->title ? Html::encode($this->title . ' - ') : '' ?><?= Html::encode('Aker Solutions') ?></title>
  <?php $this->head() ?>
</head>

<body class="admin-panel">
  <?php $this->beginBody() ?>

    <?= Alert::widget() ?>
    
  <header class="store-header">
    <?php
    NavBar::begin([
      'brandLabel' => Html::img('@web/img/logo.png'),
      'brandUrl' => '',
      'options' => [
        'class' => 'navbar-expand-lg shadow-sm',
      ],
    ]); ?>
    <?php echo !Yii::$app->user->isGuest ? Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-nav-light ml-auto'],
        'encodeLabels' => false,
        'items' => [
            [
              'label' => 'HOLERITE',
              'url' => ['/holerite']
            ],
            [
              'label' => 'INFORME DE RENDIMENTOS',
              'url' => ['/informe-rendimento']
            ],
            [
              'label' => '|'
            ], 
            [
            'label' => 'Olá, ' . Yii::$app->user->identity->NM_USUARIO ?? 'Colaborador'
            ],        
            [
                'label' => 'Sair',
                'url' => ['/auth/logout'],
                'linkOptions' => [
                    'data-method' => 'post'
                ],
            
            ],
        ]
    ]) : '';
    NavBar::end();
    ?>
  </header>

  <div class="container mt-5 pb-5">
    <?= $content ?>
  </div>

  <?php $this->endBody() ?>
</body>

</html>

<?php ?>
<?php $this->endPage() ?>