<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Detalleescalanota */

$this->title = 'Nueva Nota';
$this->params['breadcrumbs'][] = ['label' => 'Detalleescalanotas', 'url' => ['escalanota/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalleescalanota-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'escalas' => $escalas,
        'condiciones' => $condiciones,
    ]) ?>

</div>
