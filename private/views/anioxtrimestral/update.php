<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Anioxtrimestral */

$this->title = 'Modificar: ' . $model->aniolectivo0->nombre.' - '.$model->trimestral0->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Exámenes', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="anioxtrimestral-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'anio' => $anio,
        'trimestral' => $trimestral,
    ]) ?>

    
</div>
