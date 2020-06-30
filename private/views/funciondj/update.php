<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Funciondj */

$this->title = 'Modificar Funciondj: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Funciondjs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="funciondj-update">


    <?= $this->render('_form', [
        'model' => $model,
        'reparticiones' => $reparticiones,
        'update' => 1,
    ]) ?>




</div>
