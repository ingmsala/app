<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Anioxtrimestral */

$this->title = 'Nuevo Examen';
$this->params['breadcrumbs'][] = ['label' => 'Trimestrales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anioxtrimestral-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'anio' => $anio,
        'trimestral' => $trimestral,
        'duplicar' => $duplicar,
        'nuevo' => 1,
    ]) ?>

</div>
