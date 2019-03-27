<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Matricula */

$this->title = 'Nueva Matrícula';
$this->params['breadcrumbs'][] = ['label' => 'Matrículas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="matricula-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'alumnos' => $alumnos,
        'optativas' => $optativas,
        'comisiones' => $comisiones,
        'estadosmatricula' => $estadosmatricula,
    ]) ?>

</div>
