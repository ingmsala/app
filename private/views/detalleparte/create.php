<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Detalleparte */


$this->params['breadcrumbs'][] = ['label' => 'Detallepartes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalleparte-create">

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
        'tipos' => $tipos,
        'origen' => 'create',
    ]) ?>

</div>
