<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Espaciocurricular */

$this->title = 'Modificar Espacio Optativo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Espaciocurriculars', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="optativa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'actividades' => $actividades,
        'aniolectivo' => $aniolectivo,
        'areasoptativas' => $areasoptativas,
    ]) ?>

</div>
