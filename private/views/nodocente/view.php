<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Nodocente */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Nodocentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nodocente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar el elemento?',
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
            'genero',
            'documento',
            'mail',
        ],
    ]) ?>

</div>