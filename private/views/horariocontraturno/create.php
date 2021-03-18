<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Horariocontraturno */

$this->title = 'Horario contraturno: '.$divi->nombre;

?>
<div class="horariocontraturno-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'catedras' => $catedras,
        'dias' => $dias,
        'al' => $al,
        'divi' => $divi,
        'agentes' => $agentes,
    ]) ?>

</div>
