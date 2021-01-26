<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Estadodetplan */

$this->title = 'Create Estadodetplan';
$this->params['breadcrumbs'][] = ['label' => 'Estadodetplans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadodetplan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
