<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Preinscripcion */

$this->title = 'Modificar Preinscripcion: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Preinscripcions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="preinscripcion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
