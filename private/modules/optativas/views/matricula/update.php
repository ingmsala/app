<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Matricula */

$this->title = 'Update Matricula: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Matriculas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="matricula-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'alumnos' => $alumnos,
        'optativas' => $optativas,
        'comisiones' => $comisiones,
        'estadosmatricula' => $estadosmatricula,
        'divisiones' => $divisiones,
    ]) ?>

</div>
