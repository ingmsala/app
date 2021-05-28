<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becaestadoxsolicitud */

$this->title = 'Create Becaestadoxsolicitud';
$this->params['breadcrumbs'][] = ['label' => 'Becaestadoxsolicituds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="becaestadoxsolicitud-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
