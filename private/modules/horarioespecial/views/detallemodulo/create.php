<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\Detallemodulo */

$this->title = $model->grupodivision0->habilitacionce0->division0->nombre.' - Grupo '.$model->grupodivision0->nombre.' - '.$model->moduloclase0->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Detallemodulos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detallemodulo-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
        'espacios' => $espacios,
        'horarioclaseespaciales' => $horarioclaseespaciales,
        'multiple' => $multiple,
        'detallecatedras' => $detallecatedras,
    ]) ?>

</div>
