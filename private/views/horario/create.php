<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Horario */

$this->title = 'Nuevo Horario';

?>
<div class="horario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'horas' => $horas,
        'dias' => $dias,
        'tipos' => $tipos,
    ]) ?>

</div>
