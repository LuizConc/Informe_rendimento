<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = 'Entrar';
?>
<div class="auth-index">
    <div class="container pt-5 pb-6">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="p-5 ml-md-4 rounded shadow bg-white">
                    <h1 class="text-center">PAINEL DO COLABORADOR</h1>
                    <p>Preencha os seguintes campos para entrar:</p>
                    <?php
                        $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'enableAjaxValidation' => false,
                    ]);
                    ?>
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <div class="form-group d-flex justify-content-between">
                            <?= Html::submitButton('ENTRAR', ['class' => 'btn btn-primary px-4']) ?>
                            <a href="<?php echo Url::to(['/auth/request-password-reset']); ?>" class="btn btn-link">Esqueci minha senha</a>
                        </div>
                        
                    <?php ActiveForm::end(); ?>
                    <div class="row justify-content-center mt-5">
                        <a href="<?php echo Url::to(['/auth/register']); ?>" class="btn btn-link">Não tem cadatro? Clique Aqui</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
