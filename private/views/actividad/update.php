<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Actividad */

$this->title = 'Modificar Actividad: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="actividad-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'planes' =>$planes,
        'actividadtipos' =>$actividadtipos,
        'propuestas' =>$propuestas,
    ]) ?>

</div>
