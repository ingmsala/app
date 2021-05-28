<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becasolicitud */

$this->title = 'Update Becasolicitud: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Becasolicituds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="becasolicitud-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
