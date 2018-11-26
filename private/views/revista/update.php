<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Revista */

$this->title = 'Modificar Situación de Revista: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Revistas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="revista-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
