<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Solicitudedh */


$this->params['breadcrumbs'][] = ['label' => 'Solicitudedhs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitudedh-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'areas' => $areas,
        'demandantes' => $demandantes,
    ]) ?>

</div>
