<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Tipoclase */

$this->title = 'Modificar Tipo de Clase: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipo de Clases', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="tipoclase-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
