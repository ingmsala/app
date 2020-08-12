<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Docentexdepartamento */

$this->title = 'Nuevo Docentexdepartamento';
$this->params['breadcrumbs'][] = ['label' => 'Docentexdepartamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="docentexdepartamento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'departamentos' => $departamentos,
        'docentes' => $docentes,
        'funciones' => $funciones,
    ]) ?>

</div>
