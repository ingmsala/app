<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Horariocontraturno */

$this->title = 'Update Horariocontraturno: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Horariocontraturnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="horariocontraturno-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
