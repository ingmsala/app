<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\solicitudprevios\models\Detallesolicitudext */

$this->title = 'Create Detallesolicitudext';
$this->params['breadcrumbs'][] = ['label' => 'Detallesolicitudexts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detallesolicitudext-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
