<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Mesaexamen */

$this->title = 'Nuevo Mesaexamen';
$this->params['breadcrumbs'][] = ['label' => 'Mesaexamens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mesaexamen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'turnosexamen' => $turnosexamen,
        'espacios' => $espacios,
        'docentes' => $docentes,
        'actividades' => $actividades,
        'actividadesxmesa' => [],
        'tribunal' => [],
    ]) ?>

</div>
