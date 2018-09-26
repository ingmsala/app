<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Funcion */

$this->title = 'Modificar Funcion';
$this->params['breadcrumbs'][] = ['label' => 'Funciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="funcion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelcargo' => $modelcargo,
        'cargos' => $cargos,
        'docentes' => $docentes,
    ]) ?>

</div>
