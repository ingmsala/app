<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\Habilitacionce */

$this->title = 'Modificar Habilitacionce: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Habilitacionces', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="habilitacionce-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
