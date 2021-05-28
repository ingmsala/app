<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Parentesco */

$this->title = 'Update Parentesco: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Parentescos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="parentesco-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
