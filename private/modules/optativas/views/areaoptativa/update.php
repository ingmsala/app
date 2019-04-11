<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\optativas\models\Areaoptativa */

$this->title = 'Update Areaoptativa: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Areaoptativas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="areaoptativa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
