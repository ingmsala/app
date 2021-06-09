<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\desarrollo\Detalledesarrollo */

$this->title = 'Create Detalledesarrollo';
$this->params['breadcrumbs'][] = ['label' => 'Detalledesarrollos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalledesarrollo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
