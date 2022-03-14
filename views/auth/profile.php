<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Meus Dados';
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
    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'username')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('SALVAR', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>