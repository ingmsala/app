<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Temaunidad */

$this->title = 'Modificar tema de la '.$model->detalleunidad0->unidad0->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Temaunidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="temaunidad-update">

    

    <?= $this->render('_form', [
        'model' => $model,
        'create' => false,
    ]) ?>

</div>
