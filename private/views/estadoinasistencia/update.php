<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Estadoinasistencia */

$this->title = 'Update Estadoinasistencia: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Estadoinasistencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="estadoinasistencia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
