<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tiposemana */

$this->title = 'Create Tiposemana';
$this->params['breadcrumbs'][] = ['label' => 'Tiposemanas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tiposemana-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
