<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Horariogym */

$this->title = 'Create Horariogym';
$this->params['breadcrumbs'][] = ['label' => 'Horariogyms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horariogym-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
