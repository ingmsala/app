<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Avisoinasistencia */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Avisoinasistencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="avisoinasistencia-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro que desea eliminar el registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion:ntext',
            'agente',
            'desde',
            'hasta',
        ],
    ]) ?>

</div>
