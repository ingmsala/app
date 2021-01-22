<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Actuacionedh */


?>
<div class="actuacionedh-update">

    
    <?= $this->render('_form', [
        'model' => $model,
        'lugaresactuacion' => $lugaresactuacion,
        'areas' => $areas,
        'actores' => $actores,
        'modelActores' => $modelActores,
        'modelAreainf' => $modelAreainf,
    ]) ?>

</div>
