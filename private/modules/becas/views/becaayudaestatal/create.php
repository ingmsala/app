<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becaayudaestatal */

$this->title = 'Create Becaayudaestatal';
$this->params['breadcrumbs'][] = ['label' => 'Becaayudaestatals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="becaayudaestatal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
