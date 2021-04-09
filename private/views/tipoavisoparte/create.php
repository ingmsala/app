<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tipoavisoparte */

$this->title = 'Create Tipoavisoparte';
$this->params['breadcrumbs'][] = ['label' => 'Tipoavisopartes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipoavisoparte-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
