<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\mones\models\Monalumno */

$this->title = 'Modificar Monalumno: ' . $model->documento;
$this->params['breadcrumbs'][] = ['label' => 'Monalumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->documento, 'url' => ['view', 'id' => $model->documento]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="monalumno-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
