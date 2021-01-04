<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\ticket\models\Ticket */

$this->title = 'Modificar Ticket: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="ticket-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelasignacion' => $modelasignacion,
        'creadores' => $creadores,
        'prioridades' => $prioridades,
        'asignaciones' => $asignaciones,
        'modelajuntos' => $modelajuntos,
        'origen' => 'update',
        'searchModelAdjuntos' => $searchModelAdjuntos,
        'dataProviderAdjuntos' => $dataProviderAdjuntos,
    ]) ?>

</div>
