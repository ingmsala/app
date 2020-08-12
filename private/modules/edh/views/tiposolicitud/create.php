<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Tiposolicitud */

$this->title = 'Nuevo Tiposolicitud';
$this->params['breadcrumbs'][] = ['label' => 'Tiposolicituds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tiposolicitud-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
