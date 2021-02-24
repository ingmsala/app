<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Turnoexamen */

$this->title = 'Nuevo Turno de examen';

?>
<div class="turnoexamen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipos' => $tipos,
        'estados' => $estados,
    ]) ?>

</div>
