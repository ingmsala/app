<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mesaexamen */

$this->title = 'Modificar Mesaexamen: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mesaexamens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="mesaexamen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'turnosexamen' => $turnosexamen,
        'espacios' => $espacios,
        'docentes' => $docentes,
        'actividades' => $actividades,
        'actividadesxmesa' => $actividadesxmesa,
        'tribunal' => $tribunal,
    ]) ?>

</div>
