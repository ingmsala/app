<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tareamantenimiento */

$this->title = 'Nueva Tarea';

?>
<div class="tareamantenimiento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'prioridad' => $prioridad,
        'estado' => $estado,
        'nodocentes' => $nodocentes,
    ]) ?>

</div>
