<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\sociocomunitarios\models\Calificacionrubrica */

$this->title = 'Modificar Calificacionrubrica: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Calificacionrubricas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="calificacionrubrica-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'detalleescalas' => $detalleescalas,
    ]) ?>

</div>
