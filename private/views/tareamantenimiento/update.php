<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tareamantenimiento */

$this->title = 'Modificar Tarea de mantenimiento';

?>
<div class="tareamantenimiento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'prioridad' => $prioridad,
        'estado' => $estado,
        'nodocentes' => $nodocentes,
    ]) ?>

</div>
