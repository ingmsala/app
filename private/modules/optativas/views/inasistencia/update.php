<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Inasistencia */

$this->title = 'Update Inasistencia: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inasistencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="inasistencia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
