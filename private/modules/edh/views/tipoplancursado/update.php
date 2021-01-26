<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Tipoplancursado */

$this->title = 'Update Tipoplancursado: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipoplancursados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipoplancursado-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
