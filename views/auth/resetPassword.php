<?php

use yii\helpers\Url;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Redefinir Senha';
$this->registerJs("jQuery('#reveal-password').change(function(){jQuery('#userresetpasswordform-password').attr('type',this.checked?'text':'password');})");
?>
<div class="py-5">
  <div class="container">
    <div class="row">

      <div class="col-md-6">

        <div class="card border-0 bg-light">
          <div class="card-body">
            <h2 class="card-title">2 - Segunda etapa</h2>
            <?php
                    $form = ActiveForm::begin([
                        'id' => 'password-form',
                        'enableClientScript' => false,
                        'enableAjaxValidation' => true,
                    ]);
                    ?>
            <p>Informe sua nova senha e faça o login em nosso site:</p>
            <?= $form->field($model, 'password')->passwordInput()->label(false) ?>
            <?= Html::checkbox('reveal-password', false, ['id' => 'reveal-password']) ?>
            <?= Html::label('Exibir senha', 'reveal-password') ?>
            <div class="form-group mt-3">
              <?= Html::submitButton('ATUALIZAR SENHA', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
          </div>
        </div>

      </div>

      <div class="col-md-6 mt-5 mt-md-0 align-self-stretch">


        <div class="card bg-primary text-white h-100 border-0">
          <div
            class="position-relative card-body d-flex flex-column align-items-center justify-content-center text-center"
            style="z-index: 10;">
            <h2 class="card-title text-light">Lembrou o login?</h2>
            <p class="card-text">Acesse a página de login e divulgue suas locações.</p>
            <a href="<?= Url::to(['auth/index']); ?>" class="btn btn-lg btn-dark mt-1 px-5">MINHA CONTA</a>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>