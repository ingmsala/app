<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Preinscripcionxanio */

$this->title = 'Create Preinscripcionxanio';
$this->params['breadcrumbs'][] = ['label' => 'Preinscripcionxanios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preinscripcionxanio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
