<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Detalleunidad */

$this->title = 'Modificar Detalleunidad: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Detalleunidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="detalleunidad-update">

    <div class="pull-right"><?php
        echo Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar el elemento?',
                'method' => 'post',
            ],
        ])
    ?>
   </div>
   <div class="clearfix"></div>
    <?= $this->render('_form', [
        'model' => $model,
        'unidades' => $unidades,
        'multiple' => false,
    ]) ?>

</div>
