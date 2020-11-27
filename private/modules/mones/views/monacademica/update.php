<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\mones\models\Monacademica */

$this->title = 'Modificar Monacademica: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Monacademicas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="monacademica-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
