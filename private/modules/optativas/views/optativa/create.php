<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Optativa */

$this->title = 'Nueva Optativa';
$this->params['breadcrumbs'][] = ['label' => 'Optativas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="optativa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'actividades' => $actividades,
        'aniolectivo' => $aniolectivo,
    ]) ?>

</div>
