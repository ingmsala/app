<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\horarioespecial\models\Horarioclaseespecial */

$this->title = 'Modificar Horarioclaseespecial: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Horarioclaseespecials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="horarioclaseespecial-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
