<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\sociocomunitarios\models\Calificacionrubrica */

$this->title = 'Nueva Calificación';
$this->params['breadcrumbs'][] = ['label' => 'Calificacionrubricas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calificacionrubrica-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'detalleescalas' => $detalleescalas,
    ]) ?>

</div>
