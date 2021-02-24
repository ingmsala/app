<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Estadoturnoexamen */

$this->title = 'Update Estadoturnoexamen: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Estadoturnoexamens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="estadoturnoexamen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
