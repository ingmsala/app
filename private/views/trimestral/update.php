<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Trimestral */

$this->title = 'Update Trimestral: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trimestrals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trimestral-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
