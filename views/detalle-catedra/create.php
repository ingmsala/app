<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DetalleCatedra */

$this->title = 'Nuevo Docente de Catedra';
$this->params['breadcrumbs'][] = ['label' => 'Detalle Catedras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalle-catedra-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'catedra' => $catedra
    ]) ?>

</div>
