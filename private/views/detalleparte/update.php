<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Detalleparte */


$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="detalleparte-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $rnd = ($depdr) ? '_form' : '_formnosecundario'; ?>

    <?= $this->render($rnd, [
        'model' => $model,
        'partes' => $partes,
        'parte' => $parte,
        'docentes' => $docentes,
        'divisiones' => $divisiones,
        'horas' => $horas,
        'faltas' => $faltas,
        'origen' => 'update',
    ]) ?>

</div>
