<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nodocente */

$this->title = 'Modificar Nodocente: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Nodocentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="nodocente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'generos' => $generos,
        'condicion' => $condicion,
    ]) ?>

</div>
