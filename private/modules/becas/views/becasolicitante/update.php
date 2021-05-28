<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becasolicitante */

?>
<div class="becasolicitante-update">


    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'ocupaciones' => $ocupaciones,
        'nivelestudio' => $nivelestudio,
        'ayudasestatal' => $ayudasestatal,
        
        'parentescos' => $parentescos,
        'form' => $form,
    ]) ?>

<div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
