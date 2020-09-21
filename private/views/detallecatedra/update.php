<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DetalleCatedra */

$this->title = 'Modificar Docente de Catedra' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Detalle Catedras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="detalle-catedra-update">

    

    <?= $this->render('_form', [
        'model' => $model,
        'catedra' => $catedra,

        'catedras' => $catedras,
        'docentes' => $docentes,
        'condiciones' => $condiciones,
        'revistas' => $revistas,
        'anioslectivos' => $anioslectivos,
      
    ]) ?>

</div>
