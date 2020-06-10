<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Declaracionjurada */

$this->title = 'Declaración Jurada';

?>
<div class="declaracionjurada-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <h4 class="text-muted">De los cargos y actividades  que desempeña el causante</h4>

    <?= $this->render('_form', [
        'model' => $model,
        'persona' => $persona,
        'tipodocumento' => $tipodocumento,
        'localidad' => $localidad,
        'provincia' => $provincia,
        'actividadnooficial' => $actividadnooficial,
        'pasividaddj' => $pasividaddj,
        
    ]) ?>

</div>
