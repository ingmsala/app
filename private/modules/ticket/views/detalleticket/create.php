<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Detalleticket */

$this->title = 'Respuesta Ticket #'.$ticketModel->id.': '.$ticketModel->asunto;
$this->params['breadcrumbs'][] = ['label' => 'Detalletickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalleticket-create">

    

    <?= $this->render('_form', [
        'model' => $model,
        'modelasignacion' => $modelasignacion,
        'asignaciones' => $asignaciones,
        'modelajuntos' => $modelajuntos,
        'estados' => $estados,
        'estadospago' => $estadospago,
        'estaEnGrupo' => $estaEnGrupo,
        'exiteauth' => $exiteauth,
    ]) ?>

</div>
