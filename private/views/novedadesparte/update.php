<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Novedadesparte */

$this->title = 'Modificar Novedad: ' . $model->id;

?>
<div class="novedadesparte-update">


    <?= $this->render('_form', [
        'model' => $model,
        'tiponovedades' => $tiponovedades,
        'preceptores' => $preceptores,
        'cursos' => $cursos,
        'alumnos' => $alumnos,
    ]) ?>

</div>
