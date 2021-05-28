<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becaalumno */

?>
<div class="becaalumno-update">

    
    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'ocupaciones' => $ocupaciones,
        'nivelestudio' => $nivelestudio,
        'ayudasestatal' => $ayudasestatal,
        'modelocupacionesx' => $modelocupacionesx,
        'modelayudax' => $modelayudax,
        'form' => $form,
        
    ]) ?>

<div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
