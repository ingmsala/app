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

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'reparticiones' => $reparticiones,
    ]) ?>

</div>
