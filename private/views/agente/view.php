<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Agente */

$this->title = $model->apellido . ', ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Agentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro de querer eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'legajo',
            'apellido',
            'nombre',
            [
                'label'=>"Género",
                'attribute' => 'genero0.nombre'
            ],
        ],
    ]) ?>

</div>