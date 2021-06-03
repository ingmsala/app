<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\solicitudprevios\models\Solicitudinscripext */

if($t==2){
    $titulo = 'FORMULARIO SOLICITUD DE INSCRIPCIÓN A EXÁMENES PREVIOS/LIBRES – ESTUDIANTES CURSANTES '.date('Y');
}else{
    $titulo = 'FORMULARIO SOLICITUD DE INSCRIPCIÓN A EXÁMENES PREVIOS/LIBRES – ESTUDIANTES NO CURSANTES';
}


$this->title = $titulo;

?>
<div class="solicitudinscripext-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
        'modelDetalle' => $modelDetalle,
        'modelAjuntos' => $modelAjuntos,
        'turnoexamen' => $turnoexamen,
        'actividades' => $actividades,
        'divisiones' => $divisiones,
        't' => $t,
    ]) ?>

</div>
