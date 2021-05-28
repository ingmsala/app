<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\becas\models\Becaconvocatoriaestado */

$this->title = 'Create Becaconvocatoriaestado';
$this->params['breadcrumbs'][] = ['label' => 'Becaconvocatoriaestados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="becaconvocatoriaestado-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
