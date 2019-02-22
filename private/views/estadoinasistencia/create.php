<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Estadoinasistencia */

$this->title = 'Create Estadoinasistencia';
$this->params['breadcrumbs'][] = ['label' => 'Estadoinasistencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadoinasistencia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
