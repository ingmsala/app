<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Admisionoptativa */

$this->title = 'Nueva Admisión';
$this->params['breadcrumbs'][] = ['label' => 'Admisionoptativas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admisionoptativa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'alumnos' => $alumnos,
        'aniolectivos' => $aniolectivos,
        'turnos' => $turnos,
    ]) ?>

</div>
