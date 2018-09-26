<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Funcion */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Funciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="funcion-view">

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
            'nombre',
            ['label'=>"Cargo",
            'attribute' =>'cargo0.nombre'],
            'horas',
            ['label'=>"Docente",
                'value' => function ($data)
                            {
                              return $data->docente0->apellido.', '.$data->docente0->nombre;
                            }
            ],
        ],
    ]) ?>

</div>
