<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Seguimiento */

$this->title = 'Modificar Seguimiento: ' . $model->matricula0->alumno0->apellido.', '.$model->matricula0->alumno0->nombre;

?>
<div class="seguimiento-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'estados' => $estados,
        'tipos' => $tipos,
        'trimestre' => $trimestre,
       
    ]) ?>

</div>
