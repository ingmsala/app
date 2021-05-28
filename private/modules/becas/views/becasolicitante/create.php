<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becasolicitante */


?>
<div class="becasolicitante-create">



    <?= $this->render('_form', [
        'model' => $model,
        'ocupaciones' => $ocupaciones,
        'nivelestudio' => $nivelestudio,
        'ayudasestatal' => $ayudasestatal,
        'modelocupacionesx' => $modelocupacionesx,
        'modelayudax' => $modelayudax,
        'parentescos' => $parentescos,
        'form' => $form,
    ]) ?>

</div>
