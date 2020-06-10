<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Docente */

$this->title = 'Modificar Docente: ' . $model->apellido . ', ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Docentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="docente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'generos' => $generos,
        'tipodocumento' => $tipodocumento,
    ]) ?>

</div>
