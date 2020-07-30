<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Detallefonid */

$this->title = 'Modificar Detallefonid: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Detallefonids', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="detallefonid-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
