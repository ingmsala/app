<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\Detallemodulo */

$this->title = 'Modificar Detallemodulo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Detallemodulos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="detallemodulo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'espacios' => $espacios,
        'horarioclaseespaciales' => $horarioclaseespaciales,
        'multiple' => $multiple,
        'detallecatedras' => $detallecatedras,
    ]) ?>

</div>
