<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Horariocontraturno */

$this->title = 'Modificar horario contraturno: ' . $model->catedra0->division0->nombre;

?>
<div class="horariocontraturno-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'catedras' => $catedras,
        'agentes' => $agentes,
        'dias' => $dias,
        'al' => $al,
        'divi' => $divi,
    ]) ?>

</div>
