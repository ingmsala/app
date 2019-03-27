<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Calificacion */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Calificacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calificacion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea borrar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fecha',
            'matricula',
            'calificacion',
            'estadocalificacion',
        ],
    ]) ?>

</div>
