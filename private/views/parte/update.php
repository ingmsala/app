<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Parte */

$this->title = 'Modificar Parte: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Partes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="parte-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'precepx' => $precepx,
        'tiposparte' => $tiposparte,
    ]) ?>

</div>
