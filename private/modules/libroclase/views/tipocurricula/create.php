<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\libroclase\models\Tipocurricula */

$this->title = 'Create Tipocurricula';
$this->params['breadcrumbs'][] = ['label' => 'Tipocurriculas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipocurricula-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
