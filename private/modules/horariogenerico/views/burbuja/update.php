<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\horariogenerico\models\Burbuja */

$this->title = 'Update Burbuja: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Burbujas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="burbuja-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
