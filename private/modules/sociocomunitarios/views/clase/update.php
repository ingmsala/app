<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Clase */

$this->title = 'Modificar Encuentro: ' . $model->id;

?>
<div class="clase-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tiposclase' => $tiposclase,
        'tiposasistencia' => $tiposasistencia,
        'mesx' => $mesx,
    ]) ?>

</div>
