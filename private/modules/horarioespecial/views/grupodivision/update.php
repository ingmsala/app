<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\Grupodivision */

$this->title = 'Modificar Grupodivision: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Grupodivisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="grupodivision-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
