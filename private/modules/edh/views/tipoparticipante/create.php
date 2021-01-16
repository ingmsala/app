<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\edh\models\Tipoparticipante */

$this->title = 'Create Tipoparticipante';
$this->params['breadcrumbs'][] = ['label' => 'Tipoparticipantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipoparticipante-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
