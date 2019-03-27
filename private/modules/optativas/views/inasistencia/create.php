<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Inasistencia */

$this->title = 'Create Inasistencia';
$this->params['breadcrumbs'][] = ['label' => 'Inasistencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inasistencia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
