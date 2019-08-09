<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Avisoinasistencia */

$this->title = 'Nuevo aviso de Inasistencia';
$this->params['breadcrumbs'][] = ['label' => 'Avisoinasistencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="avisoinasistencia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'docentes' => $docentes,
    ]) ?>

</div>
