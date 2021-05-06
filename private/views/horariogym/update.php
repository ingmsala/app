<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Horariogym */

$this->title = 'Update Horariogym: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Horariogyms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="horariogym-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
