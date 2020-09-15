<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Divisionxmesa */

$this->title = 'Modificar Divisionxmesa: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Divisionxmesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="divisionxmesa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
