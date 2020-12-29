<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Agente */

$this->title = 'Modificar Agente: ' . $model->apellido . ', ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Agentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="agente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'generos' => $generos,
        'tipodocumento' => $tipodocumento,
        'tipocargo' => $tipocargo,
        'origen' => 'update',
        'dataProvider' => $dataProvider,
        
    ]) ?>

</div>
