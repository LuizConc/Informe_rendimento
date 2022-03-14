<?php

use yii\helpers\Url;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Cadastre-se';
$this->registerJs("jQuery('#reveal-password').change(function(){jQuery('#users-ds_senha').attr('type',this.checked?'text':'password');})");
?>

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow border-0 bg-light">
                <div class="card-body">
                    <h2 class="card-title">Informe seus dados</h2>
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'register-form',
                        'enableClientScript' => true,
                        'enableAjaxValidation' => true,
                    ]);
                    ?>
                    <?= $form->errorSummary($model); ?>
                    <?= $form->field($model, 'NM_USUARIO') ?>
                    <?= $form->field($model, 'DS_LOGIN')->hint('Número que será informado no Login.') ?>
                    <?= $form->field($model, 'DS_SENHA')->passwordInput() ?>
                    <?= Html::checkbox('reveal-password', false, ['id' => 'reveal-password']) ?> <?= Html::label('Exibir senha', 'reveal-password') ?>
                    <div class="form-group">
                        <?= Html::submitButton('CADASTRAR', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        <a href="<?= Url::to(['auth/index']); ?>" class="btn btn-secondary">VOLTAR</a>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>

    </div>
</div>