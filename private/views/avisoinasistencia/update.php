<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Avisoinasistencia */

$this->title = 'Modificar aviso de Inasistencia: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Avisoinasistencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="avisoinasistencia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'docentes' => $docentes,
    ]) ?>

</div>
