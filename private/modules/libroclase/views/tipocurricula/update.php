<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Tipocurricula */

$this->title = 'Update Tipocurricula: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipocurriculas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipocurricula-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
