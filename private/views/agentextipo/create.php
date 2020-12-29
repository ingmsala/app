<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Agentextipo */

$this->title = 'Nuevo Tipo de cargo';
$this->params['breadcrumbs'][] = ['label' => 'Agentextipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agentextipo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipocargo' => $tipocargo,
        'agentex' => $agentex,
    ]) ?>

</div>
