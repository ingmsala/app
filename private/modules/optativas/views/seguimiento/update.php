<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Seguimiento */

$this->title = 'Update Seguimiento: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Seguimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="seguimiento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
