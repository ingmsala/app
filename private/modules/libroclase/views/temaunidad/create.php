<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Temaunidad */

$this->title = 'Nuevo tema de la '.$model->detalleunidad0->unidad0->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Temaunidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="temaunidad-create">

    
    <?= $this->render('_form', [
        'model' => $model,
        'create' => true,
    ]) ?>

</div>
