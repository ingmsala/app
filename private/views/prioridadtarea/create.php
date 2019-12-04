<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Prioridadtarea */

$this->title = 'Nuevo Prioridadtarea';
$this->params['breadcrumbs'][] = ['label' => 'Prioridadtareas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prioridadtarea-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
