<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Horaxclase */

$this->title = 'Update Horaxclase: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Horaxclases', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="horaxclase-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
