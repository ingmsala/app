<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Parte */
$this->title = 'Nuevo Parte Docente';
$this->params['breadcrumbs'][] = ['label' => 'Partes', 'url' => ['/parte']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parte-create">

	<h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'precepx' => $precepx,
    ]) ?>

</div>
