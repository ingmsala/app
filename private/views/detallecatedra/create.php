<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DetalleCatedra */

$this->title = 'Nuevo Docente de Catedra';
$this->params['breadcrumbs'][] = ['label' => 'Detalle Catedras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalle-catedra-create">

    

    <?= $this->render('_form', [
        'model' => $model,
        'catedra' => $catedra,

        'catedras' => $catedras,
        'docentes' => $docentes,
        'condiciones' => $condiciones,
        'revistas' => $revistas,
    ]) ?>

</div>
