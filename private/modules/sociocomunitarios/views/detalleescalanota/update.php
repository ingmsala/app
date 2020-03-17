<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Detalleescalanota */

$this->title = 'Modificar Nota: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Detalleescalanotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="detalleescalanota-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'escalas' => $escalas,
        'condiciones' => $condiciones,
    ]) ?>

</div>
