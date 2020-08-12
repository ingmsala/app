<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Docentexdepartamento */

$this->title = 'Modificar Docentexdepartamento: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Docentexdepartamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="docentexdepartamento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'departamentos' => $departamentos,
        'docentes' => $docentes,
        'funciones' => $funciones,
    ]) ?>

</div>
