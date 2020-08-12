<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Detalleunidad */

$this->title = 'Nueva unidad';
$this->params['breadcrumbs'][] = ['label' => 'Detalleunidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalleunidad-create">

    
    <?= $this->render('_form', [
        'model' => $model,
        'unidades' => $unidades,
        'multiple' => true,
    ]) ?>

</div>
