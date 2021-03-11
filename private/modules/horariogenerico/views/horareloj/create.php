<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\horariogenerico\models\Horareloj */

$this->title = 'Generar Horas';
$this->params['breadcrumbs'][] = ['label' => 'Horarelojs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horareloj-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'anios' => $anios,
        'turnos' => $turnos,
        'horas' => $horas,
    ]) ?>

</div>
