<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Agentextipo */

$this->title = 'Modificar Agentextipo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Agentextipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="agentextipo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
