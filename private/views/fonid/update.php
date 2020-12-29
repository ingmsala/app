<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fonid */

$this->title = 'Ministerio de Educación Ciencia y Tecnología';
$this->params['breadcrumbs'][] = ['label' => 'Fonids', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="fonid-update">

    <h2><?= Html::encode($this->title) ?></h2>
    <h3><?= Html::encode('FONID '.date('Y')) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => $dataProvider,
        'fonid' => $model->id,
        'agente' => $agente,
    ]) ?>

</div>
