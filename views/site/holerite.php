<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = 'Holerite';
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create text-center">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="form text-center">
        <?php $form = ActiveForm::begin(); ?>

        <div class="form-group"> 
            <div class="row mx-auto">
                <div class="col-md-6 mx-auto">
                    <div class="row">
                <?= $form->field($model, 'type', ['options' => ['class' => 'col-md-6 col-sx-1']])->dropDownList($listTypes) ?>
                <?= $form->field($model, 'validity', ['options' => ['class' => 'col-md-6 col-sx-1']])
                ->widget(MaskedInput::class, [
                  'mask' => '99/9999',
                  'clientOptions' => ['greedy' => false]
              ]) ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-group">
            <?= Html::submitButton('Solicitar', ['class' => 'btn btn-primary rounded col-md-2 mt-2']) ?>
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