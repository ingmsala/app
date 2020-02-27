<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Seguimiento */

$this->title = $matr->alumno0->apellido.', '.$matr->alumno0->nombre;

?>
<div class="seguimiento-create">

    <h3>Seguimiento: <?= Html::encode($this->title) ?>
    <?php
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    echo ' - Fecha: '.Yii::$app->formatter->asDate($model->fecha, 'dd/MM/yyyy');
    ?></h3>
    <?= $this->render('_form', [
        'model' => $model,
        'estados' => $estados,
        'tipos' => $tipos,
        'trimestre' => $trimestre,
    ]) ?>

</div>
