<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\mones\models\Monalumno */

$this->title = 'Nuevo Monalumno';
$this->params['breadcrumbs'][] = ['label' => 'Monalumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monalumno-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>