<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Turnoexamen */

$this->title = 'Modificar Turnoexamen: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Turnoexamens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="turnoexamen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
