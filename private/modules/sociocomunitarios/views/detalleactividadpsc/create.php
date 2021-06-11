<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\sociocomunitarios\models\Detalleactividadpsc */

$this->title = 'Create Detalleactividadpsc';
$this->params['breadcrumbs'][] = ['label' => 'Detalleactividadpscs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalleactividadpsc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
