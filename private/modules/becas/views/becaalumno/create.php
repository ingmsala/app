<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becaalumno */


?>
<div class="becaalumno-create">

    
    <?= $this->render('_form', [
        'model' => $model,
        'ocupaciones' => $ocupaciones,
        'nivelestudio' => $nivelestudio,
        'ayudasestatal' => $ayudasestatal,
        'modelocupacionesx' => $modelocupacionesx,
        'modelayudax' => $modelayudax,
        'form' => $form,
    ]) ?>

</div>
