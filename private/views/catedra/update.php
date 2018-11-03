<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Catedra */

$this->title = 'Modificar Catedra';
$this->params['breadcrumbs'][] = ['label' => 'Catedras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="catedra-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelpropuesta' => $modelpropuesta,
        'actividades' => $actividades,
        'divisiones' => $divisiones,
        'propuestas' => $propuestas,
    ]) ?>

</div>
