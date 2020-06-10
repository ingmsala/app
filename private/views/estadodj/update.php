<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Estadodj */

$this->title = 'Modificar Estadodj: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Estadodjs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="estadodj-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
