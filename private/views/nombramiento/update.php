<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nombramiento */

$this->title = 'Modificar Nombramiento: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Nombramientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nombramiento-update">

    

    <?= $this->render('_form', [
        'model' => $model,

        'cargos' => $cargos,
        'docentes' => $docentes,
        'revistas' => $revistas,
        'divisiones' => $divisiones,
        'condiciones' => $condiciones,
        'suplentes' => $suplentes,
        'extensiones' => $extensiones,
    ]) ?>

</div>
