<?php

use yii\helpers\Url;
use yii\bootstrap4\Html;
use kartik\form\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Redefinir Senha';
?>
<div class="py-2">
  <div class="container">
    <div class="row d-flex justify-content-center">

      <div class="col-md-6">

        <div class="card border-0 bg-light rounded shadow">
          <div class="card-body">
            <h2 class="card-title">Salvar nova senha</h2>
            <?php
              $form = ActiveForm::begin([
                  'id' => 'reset-form',
                  'enableClientScript' => true,
                  'enableAjaxValidation' => false,
              ]);
            ?>
              <?= $form->errorSummary($model); ?>
              <?= $form->field($model, 'codUser')->widget(MaskedInput::class, [
                  'mask' => '9',
                  'clientOptions' => ['repeat' => 10, 'greedy' => false]
              ]) ?>
              <?= $form->field($model, 'birthDate')
                ->widget(MaskedInput::class, [
                  'mask' => '99/99/9999',
                  'clientOptions' => ['greedy' => false]
              ]) ?>
              <?= $form->field($model, 'document')
                ->widget(MaskedInput::class, [
                  'mask' => '999.999.999-99',
                  'clientOptions' => ['greedy' => false]
              ]) ?>
              <?= $form->field($model, 'password')->passwordInput() ?>
              <?= $form->field($model, 'password_repeat')->passwordInput() ?>
              <div class="form-group d-flex justify-content-between">
                <?= Html::submitButton('SALVAR', ['class' => 'btn btn-primary rounded']) ?>
                <a href="<?php echo Url::to(['/auth']); ?>" class="btn btn-link">Voltar para o Login</a>
              </div>
            <?php ActiveForm::end(); ?>
          </div>
        </div>

      </div>



    </div>
  </div>
</div>