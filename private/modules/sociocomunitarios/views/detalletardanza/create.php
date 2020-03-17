<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Detalletardanza */

$this->title = 'Nuevo Detalletardanza';
$this->params['breadcrumbs'][] = ['label' => 'Detalletardanzas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalletardanza-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
