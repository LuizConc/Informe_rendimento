<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->registerJs("jQuery('#reveal-password').change(function(){jQuery('#passwordform-password').attr('type',this.checked?'text':'password');})");
$this->title = 'Alterar senha';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card card-body">
    <h2 class="title">
        <?= Html::encode($this->title) ?>
    </h2>
    <?php
    $form = ActiveForm::begin([
        'id' => 'password-form',
        'enableAjaxValidation' => true,
    ]);
    ?>
    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
    <?= Html::checkbox('reveal-password', false, ['id' => 'reveal-password']) ?> <?= Html::label('Exibir senha', 'reveal-password') ?>
    <div class="form-group">
        <?= Html::submitButton('SALVAR', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>