<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Admisionoptativa */

$this->title = 'Modificar Admisión: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Admisionoptativas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="admisionoptativa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'alumnos' => $alumnos,
        'aniolectivos' => $aniolectivos,

    ]) ?>

</div>
