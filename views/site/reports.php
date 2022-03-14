<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = 'Informe de Rendimentos';
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create text-center">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="form text-center">

        <?php $form = ActiveForm::begin(); ?>

        <div class="form-group"> 
            <div class="row">
                <?= $form->field($model, 'year', ['options' => ['class' => 'col-md-3 mx-auto col-sx-1']])->dropDownList($listYears) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Solicitar', ['class' => 'btn btn-primary rounded']) ?>
        </div>

        <?php if(isset($msg)): ?>
            <div class="msg" style="color:red"><?= $msg; ?></div>
        <?php endif; ?>

        <?php ActiveForm::end(); ?>

    </div>

    <?php if(!empty($file)): ?>               
        <div class="mt-5">
            <embed src="<?= $file; ?>" width="760" height="500" type='application/pdf'>
        </div>
    <?php endif; ?>

</div>

<?php 
    $this->registerJs(
        "$('form').submit(function(e) {
            $('.msg').remove();
            $('.btn').prop('disabled',true);
            $('.btn').html('Solicitar <span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>');
        });"

    );
?>