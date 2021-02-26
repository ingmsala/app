<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\solicitudprevios\models\Estadodetallesolicitudext */

$this->title = 'Update Estadodetallesolicitudext: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Estadodetallesolicitudexts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="estadodetallesolicitudext-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
