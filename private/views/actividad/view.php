<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Actividad */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actividad-view">

    <h1><?= 'Actividad Id: '. Html::encode($this->title) ?></h1>

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
            'nombre',
            'cantHoras',
            [   
                'label'=>"Tipo de Actividad",
                'attribute' => 'actividadtipo0.nombre'
            ],
            [   
                'label'=>"Plan de Estudios",
                'attribute' => 'plan0.nombre'
            ],
            [   
                'label'=>"Propuesta Formativa",
                'attribute' => 'propuesta0.nombre'
            ],
        ],
    ]) ?>

</div>
