<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Informeprofesional */

$this->title = 'Update Informeprofesional: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Informeprofesionals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="informeprofesional-update">

    <?= $this->render('_form', [
        'model' => $model,
        'areas' => $areas,
        'origen' => 'update',
    ]) ?>

</div>
