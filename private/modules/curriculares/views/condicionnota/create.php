<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Condicionnota */

$this->title = 'Nueva Condición';
$this->params['breadcrumbs'][] = ['label' => 'Condicionnotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="condicionnota-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
