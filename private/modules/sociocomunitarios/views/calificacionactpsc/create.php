<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\sociocomunitarios\models\Calificacionactpsc */

$this->title = 'Create Calificacionactpsc';
$this->params['breadcrumbs'][] = ['label' => 'Calificacionactpscs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calificacionactpsc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
