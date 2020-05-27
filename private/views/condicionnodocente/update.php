<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Condicionnodocente */

$this->title = 'Modificar Condicionnodocente: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Condicionnodocentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="condicionnodocente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
