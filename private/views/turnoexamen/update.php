<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Turnoexamen */

$this->title = 'Modificar Turno de examen: ' . $model->id;

?>
<div class="turnoexamen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipos' => $tipos,
        'estados' => $estados,
    ]) ?>

</div>
