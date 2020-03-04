<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Preinscripcion */

$this->title = 'Preinscripción: ' . $model->descripcion;

?>
<div class="preinscripcion-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
        'tipodepublicacion' => $tipodepublicacion,
    ]) ?>

</div>
