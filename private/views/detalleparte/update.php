<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Detalleparte */

$this->title = 'Update Detalleparte: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Detallepartes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="detalleparte-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'partes' => $partes,
        'parte' => $parte,
        'docentes' => $docentes,
        'divisiones' => $divisiones,
        'horas' => $horas,
    ]) ?>

</div>
