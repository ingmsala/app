<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Horariodj */

$this->title = 'Modificar Horariodj: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Horariodjs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="horariodj-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
