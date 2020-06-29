<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\Moduloclase */

$this->title = 'Modificar Moduloclase: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Moduloclases', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="moduloclase-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
